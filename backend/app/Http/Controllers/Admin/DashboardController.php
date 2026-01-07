<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6); // inclui hoje
        $sevenDaysAhead = Carbon::today()->addDays(7);

        // Reservas HOJE
        $reservationsTodayQuery = Reservation::whereDate('date', $today);

        $reservationsToday = $reservationsTodayQuery
            ->with(['table', 'event'])
            ->orderBy('time')
            ->get();

        $totalToday     = (clone $reservationsTodayQuery)->count();
        $pendingToday   = (clone $reservationsTodayQuery)->where('status', 'pending')->count();
        $confirmedToday = (clone $reservationsTodayQuery)->where('status', 'confirmed')->count();

        // Reservas últimos 7 dias
        $reservationsLast7Days = Reservation::selectRaw('date, COUNT(*) as total')
            ->whereBetween('date', [$sevenDaysAgo, $today])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($row) {
                return [
                    Carbon::parse($row->date)->format('d/m') => $row->total,
                ];
            });

        // Próximos eventos
        $upcomingEvents = Event::where('is_active', true)
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(5)
            ->get()
            ->map(function (Event $event) {
                $currentPeople = Reservation::where('event_id', $event->id)
                    ->whereIn('status', ['pending', 'confirmed', 'seated'])
                    ->sum('num_people');

                $capacity = $event->capacity ?? 0;

                $occupancy = $capacity > 0
                    ? round(($currentPeople / $capacity) * 100)
                    : null;

                return [
                    'event'         => $event,
                    'currentPeople' => $currentPeople,
                    'capacity'      => $capacity,
                    'occupancy'     => $occupancy,
                ];
            });

        return view('admin.dashboard', [
            'today'                => $today,
            'reservationsToday'    => $reservationsToday,
            'totalToday'           => $totalToday,
            'pendingToday'         => $pendingToday,
            'confirmedToday'       => $confirmedToday,
            'reservationsLast7Days'=> $reservationsLast7Days,
            'upcomingEvents'       => $upcomingEvents,
        ]);
    }
}
