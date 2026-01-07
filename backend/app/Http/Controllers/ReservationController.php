<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Event;
use App\Models\Block;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\ReservationCreatedMail;
use App\Mail\ReservationConfirmedMail;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    // Formulário de reserva
    public function create()
    {
        // (opcional) podes filtrar por mesas ativas
        $tables = Table::orderBy('name')->get();

        // Eventos disponíveis: ativos e de hoje para a frente
        $events = Event::where('is_active', true)
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('reservations.create', compact('tables', 'events'));
    }

    // Submissão do formulário 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'nullable|string|max:20',
            'customer_email'  => 'nullable|email|max:255',
            'date'            => 'required|date',
            'time'            => 'required|date_format:H:i',
            'num_people'      => 'required|integer|min:1',
            'table_id'        => 'nullable|exists:tables,id',
            'event_id'        => 'nullable|exists:events,id',
            'notes'           => 'nullable|string',
        ]);

        // Escolher mesa ou evento
        if (empty($validated['table_id']) && empty($validated['event_id'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'table_id' => 'Escolhe uma mesa ou um evento para concluir a reserva.',
                ]);
        }

        // Validar horário vs dia da semana 
        $date = Carbon::parse($validated['date']);
        $time = Carbon::createFromFormat('H:i', $validated['time']);

        // Seg = fechado | Ter–Sex 16:00–23:00 | Sáb–Dom 09:00–23:00
        $day = $date->dayOfWeekIso; // 1=Seg ... 7=Dom

        if ($day === 1) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'Estamos fechados à segunda-feira. Escolhe outro dia.']);
        }

        if ($day >= 2 && $day <= 5) {
            $open  = Carbon::createFromFormat('H:i', '16:00');
            $close = Carbon::createFromFormat('H:i', '23:00');
        } else {
            $open  = Carbon::createFromFormat('H:i', '09:00');
            $close = Carbon::createFromFormat('H:i', '23:00');
        }

        // última reserva
        $last = Carbon::createFromFormat('H:i', '22:30');

        if ($time->lt($open) || $time->gt($close) || $time->gt($last)) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'Horário inválido para o dia escolhido. Ter–Sex: 16:00–22:30 · Sáb–Dom: 09:00–22:30.',
                ]);
        }

        // Validar bloqueios (global + por zona)
        $zoneToCheck = 'global';

        $selectedTable = null;
        if (!empty($validated['table_id'])) {
            $selectedTable = Table::findOrFail($validated['table_id']);
            $zoneToCheck = $selectedTable->zone; // interior/esplanada/palco/outro
        }

        $hasBlock = Block::whereDate('date', $date->toDateString())
            ->where(function ($q) use ($zoneToCheck) {
                // Bloqueios globais 
                $q->where('zone', 'global');

                // Bloqueios específicos
                if (!empty($zoneToCheck) && $zoneToCheck !== 'global') {
                    if (in_array($zoneToCheck, ['interior', 'esplanada', 'palco'], true)) {
                        $q->orWhere('zone', $zoneToCheck);
                    }
                }
            })
            // Se time estiver dentro do intervalo do bloqueio
            ->where('start_time', '<=', $validated['time'])
            ->where('end_time', '>=', $validated['time'])
            ->exists();

        if ($hasBlock) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'Não é possível reservar para este horário (bloqueado para manutenção/atividade). Escolhe outro horário.',
                ]);
        }

        // Prevenir double booking de mesas (mesma mesa, data e hora)
        if (!empty($validated['table_id'])) {
            $exists = Reservation::where('table_id', $validated['table_id'])
                ->whereDate('date', $date->toDateString())
                ->where('time', $validated['time'])
                ->whereIn('status', ['pending', 'confirmed', 'seated'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'table_id' => 'Essa mesa já está reservada para essa data e hora. Escolhe outra mesa ou horário.',
                    ]);
            }

            // (Opcional) validar capacidade da mesa vs num_people
            if ($selectedTable && $validated['num_people'] > (int) $selectedTable->capacity) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'num_people' => 'O número de pessoas excede a capacidade da mesa selecionada.',
                    ]);
            }
        }

        // Se a reserva for para um evento, validar capacidade
        if (!empty($validated['event_id'])) {
            $event = Event::findOrFail($validated['event_id']);

            if (!is_null($event->capacity)) {
                $currentPeople = Reservation::where('event_id', $event->id)
                    ->whereIn('status', ['pending', 'confirmed', 'seated'])
                    ->sum('num_people');

                $requested = (int) $validated['num_people'];

                if ($currentPeople + $requested > (int) $event->capacity) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'event_id' => 'Este evento já atingiu a capacidade máxima.',
                        ]);
                }
            }
        }

        // Informação interna
        $validated['user_id'] = null;      // sem login
        $validated['status']  = 'pending';
        $validated['source']  = 'website';

        // Criar reserva
        $reservation = Reservation::create($validated);

        // Enviar audit log para Node (Mongo)
        $this->sendAuditLogSafe([
            'reservation_id' => $reservation->id,
            'action' => 'reservation_created',
            'source' => 'website',
            'actor_user_id' => null,
            'meta' => [
                'date' => (string) $reservation->date,
                'time' => (string) $reservation->time,
                'num_people' => (int) $reservation->num_people,
                'table_id' => $reservation->table_id,
                'event_id' => $reservation->event_id,
            ],
        ]);

        // Enviar email de "pedido recebido"
        if ($reservation->customer_email) {
            try {
                Mail::to($reservation->customer_email)
                    ->send(new ReservationCreatedMail($reservation));

                $this->sendAuditLogSafe([
                    'reservation_id' => $reservation->id,
                    'action' => 'email_sent',
                    'source' => 'laravel_mail',
                    'actor_user_id' => null,
                    'meta' => [
                        'type' => 'ReservationCreatedMail',
                        'to' => $reservation->customer_email,
                    ],
                ]);
            } catch (\Throwable $e) {
                Log::warning('Failed to send ReservationCreatedMail: ' . $e->getMessage());

                $this->sendAuditLogSafe([
                    'reservation_id' => $reservation->id,
                    'action' => 'email_failed',
                    'source' => 'laravel_mail',
                    'actor_user_id' => null,
                    'meta' => [
                        'type' => 'ReservationCreatedMail',
                        'to' => $reservation->customer_email,
                        'error' => $e->getMessage(),
                    ],
                ]);
            }
        }

        // Resumo para o feedback
        $tableName  = optional($reservation->table)->name;
        $eventTitle = optional($reservation->event)->title;

        return redirect()
            ->route('reservations.create')
            ->with('success', 'Reserva criada com sucesso! Recebemos o teu pedido e vais receber um email com os detalhes.')
            ->with('reservation_summary', [
                'customer_name'  => $reservation->customer_name,
                'customer_phone' => $reservation->customer_phone,
                'customer_email' => $reservation->customer_email,
                'date'           => $reservation->date,
                'time'           => $reservation->time,
                'num_people'     => $reservation->num_people,
                'table_name'     => $tableName,
                'event_title'    => $eventTitle,
                'notes'          => $reservation->notes,
                'status'         => $reservation->status, 
            ]);
    }

    // Lista de reservas com filtros
    public function index(Request $request)
    {
        $selectedDate    = $request->input('date');      
        $selectedEventId = $request->input('event_id');
        $selectedStatus  = $request->input('status');

        $query = Reservation::with(['table', 'event']);

        if (!empty($selectedDate)) {
            $query->whereDate('date', $selectedDate);
        }

        if (!empty($selectedEventId)) {
            $query->where('event_id', $selectedEventId);
        }

        if (!empty($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $reservations = $query
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        $events = Event::orderBy('date')
            ->orderBy('start_time')
            ->get();

        $statuses = [
            'pending'   => 'Pendente',
            'confirmed' => 'Confirmada',
            'seated'    => 'Em mesa',
            'cancelled' => 'Cancelada',
            'no_show'   => 'No-show',
        ];

        return view('reservations.index', [
            'reservations'    => $reservations,
            'selectedDate'    => $selectedDate, // pode ser null
            'events'          => $events,
            'selectedEventId' => $selectedEventId,
            'statuses'        => $statuses,
            'selectedStatus'  => $selectedStatus,
        ]);
    }

    // Atualizar estado da reserva
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,seated,cancelled,no_show',
        ]);

        $oldStatus = $reservation->status;

        $reservation->status = $validated['status'];
        $reservation->save();

        // Mudança de estado
        $this->sendAuditLogSafe([
            'reservation_id' => $reservation->id,
            'action' => 'status_changed',
            'source' => 'admin_panel',
            'actor_user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $reservation->status,
            'meta' => [
                'date' => (string) $reservation->date,
                'time' => (string) $reservation->time,
            ],
        ]);

        // "confirmado" + email, enviar notificação
        if (
            $oldStatus !== 'confirmed'
            && $reservation->status === 'confirmed'
            && $reservation->customer_email
        ) {
            try {
                Mail::to($reservation->customer_email)
                    ->send(new ReservationConfirmedMail($reservation));

                $this->sendAuditLogSafe([
                    'reservation_id' => $reservation->id,
                    'action' => 'email_sent',
                    'source' => 'laravel_mail',
                    'actor_user_id' => auth()->id(),
                    'meta' => [
                        'type' => 'ReservationConfirmedMail',
                        'to' => $reservation->customer_email,
                    ],
                ]);
            } catch (\Throwable $e) {
                Log::warning('Failed to send ReservationConfirmedMail: ' . $e->getMessage());

                $this->sendAuditLogSafe([
                    'reservation_id' => $reservation->id,
                    'action' => 'email_failed',
                    'source' => 'laravel_mail',
                    'actor_user_id' => auth()->id(),
                    'meta' => [
                        'type' => 'ReservationConfirmedMail',
                        'to' => $reservation->customer_email,
                        'error' => $e->getMessage(),
                    ],
                ]);
            }
        }

        return redirect()
            ->route('reservations.index', ['date' => $reservation->date])
            ->with('success', 'Estado atualizado com sucesso.');
    }

    // Histórico da reserva (logs no Mongo via Node API)
    public function history(Reservation $reservation)
    {
        $logs = [];

        $baseUrl = env('NODE_API_URL');
        $apiKey  = env('NODE_API_KEY');

        if (!$baseUrl || !$apiKey) {
            return view('reservations.history', [
                'reservation' => $reservation->load(['table', 'event', 'user']),
                'logs' => $logs,
                'error' => 'NODE_API_URL/NODE_API_KEY não configurados.',
            ]);
        }

        try {
            $response = Http::timeout(3)
                ->withHeaders([
                    'x-api-key' => $apiKey,
                    'accept' => 'application/json',
                ])
                ->get(rtrim($baseUrl, '/') . '/api/logs/' . $reservation->id);

            if ($response->successful()) {
                $logs = $response->json('logs') ?? [];
            } else {
                Log::warning('Node API history request failed', [
                    'reservation_id' => $reservation->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return view('reservations.history', [
                    'reservation' => $reservation->load(['table', 'event', 'user']),
                    'logs' => $logs,
                    'error' => 'Não foi possível obter histórico (Node API respondeu com erro).',
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to fetch reservation history: ' . $e->getMessage(), [
                'reservation_id' => $reservation->id,
            ]);

            return view('reservations.history', [
                'reservation' => $reservation->load(['table', 'event', 'user']),
                'logs' => $logs,
                'error' => 'Não foi possível ligar ao Node API.',
            ]);
        }

        return view('reservations.history', [
            'reservation' => $reservation->load(['table', 'event', 'user']),
            'logs' => $logs,
            'error' => null,
        ]);
    }
    
    //Envia logs para o Node API (Mongo) sem quebrar o fluxo da aplicação.
    private function sendAuditLogSafe(array $payload): void
    {
        $baseUrl = env('NODE_API_URL');
        if (!$baseUrl) {
            return; 
        }

        $apiKey = env('NODE_API_KEY');
        if (!$apiKey) {
            return; // sem KEY não envia
        }

        try {
            Http::timeout(2)
                ->withHeaders([
                    'x-api-key' => $apiKey,
                    'accept' => 'application/json',
                ])
                ->post(rtrim($baseUrl, '/') . '/api/logs', $payload);
        } catch (\Throwable $e) {
            Log::warning('Node audit log failed: ' . $e->getMessage());
        }
    }
}
