@extends('layouts.union')

@section('title', 'Reservar mesa · Union Sports & Culture')

@section('content')
<section class="uc-section uc-section-alt">
    <div class="uc-container">

        <div class="uc-page-head">
            <p class="uc-kicker">Reservas</p>
            <h2>Reserva a tua mesa</h2>
            <p class="uc-section-intro">
                Garante o teu lugar para ver o jogo, jantar com amigos ou vir em família.
                Confirmamos a reserva assim que possível.
            </p>
        </div>

        @php
            $r = session('reservation_summary');
            $status = is_array($r) ? ($r['status'] ?? 'pending') : 'pending';
        @endphp

        @if(session('success'))

            <div class="uc-success-card" id="reserva-sucesso">
                <p class="uc-kicker">Reserva enviada</p>
                <h2>Pedido recebido ✅</h2>
                <p class="uc-success-text">{{ session('success') }}</p>

                @if(is_array($r))
                    <div class="uc-summary-card">
                        <div class="uc-summary-title">Resumo do pedido</div>

                        <div class="uc-summary-grid">
                            <div>
                                <span>Nome</span>
                                <strong>{{ $r['customer_name'] ?? '—' }}</strong>
                            </div>

                            <div>
                                <span>Pessoas</span>
                                <strong>{{ $r['num_people'] ?? '—' }}</strong>
                            </div>

                            <div>
                                <span>Data</span>
                                <strong>
                                    {{ !empty($r['date']) ? \Illuminate\Support\Carbon::parse($r['date'])->format('d/m/Y') : '—' }}
                                </strong>
                            </div>

                            <div>
                                <span>Hora</span>
                                <strong>{{ $r['time'] ?? '—' }}</strong>
                            </div>

                            <div class="uc-summary-full">
                                <span>Telefone</span>
                                <strong>{{ $r['customer_phone'] ?? '—' }}</strong>
                            </div>

                            <div class="uc-summary-full">
                                <span>Email</span>
                                <strong>{{ $r['customer_email'] ?? '—' }}</strong>
                            </div>

                            <div>
                                <span>Mesa</span>
                                <strong>{{ $r['table_name'] ?? '—' }}</strong>
                            </div>

                            <div>
                                <span>Evento</span>
                                <strong>{{ $r['event_title'] ?? '—' }}</strong>
                            </div>

                            @if(!empty($r['notes']))
                                <div class="uc-summary-full">
                                    <span>Observações</span>
                                    <strong>{{ $r['notes'] }}</strong>
                                </div>
                            @endif

                            <div class="uc-summary-full">
                                <span>Estado</span>
                                <strong>
                                    <span class="uc-badge">
                                        @switch($status)
                                            @case('confirmed') Confirmada @break
                                            @case('seated') Em mesa @break
                                            @case('cancelled') Cancelada @break
                                            @case('no_show') No-show @break
                                            @default Pendente de confirmação
                                        @endswitch
                                    </span>
                                </strong>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="uc-success-steps">
                    <div class="uc-step">
                        <div class="uc-step-dot"></div>
                        <div><strong>Agora:</strong> a tua reserva fica <span class="uc-badge">Pendente de confirmação</span>.</div>
                    </div>
                    <div class="uc-step">
                        <div class="uc-step-dot"></div>
                        <div><strong>Seguinte:</strong> confirmamos contigo assim que possível.</div>
                    </div>
                    <div class="uc-step">
                        <div class="uc-step-dot"></div>
                        <div>Se precisares de alterar, contacta-nos e indica o teu nome e a data.</div>
                    </div>
                </div>

                <div class="uc-success-actions">
                    <a href="{{ route('union.home') }}" class="uc-btn-primary">Voltar ao site</a>
                    <a href="{{ route('reservations.create') }}" class="uc-btn-ghost">Fazer nova reserva</a>
                </div>

                <div class="uc-success-mini">
                    <span><strong>Email:</strong> rematedecisivo@gmail.com</span>
                    <span><strong>Tel:</strong> 912 345 678</span>
                </div>
            </div>

            <script>
                (function () {
                    const summary = @json(session('reservation_summary'));
                    if (!summary) return;

                    const payload = { savedAt: new Date().toISOString(), summary };
                    localStorage.setItem("union_last_reservation", JSON.stringify(payload));
                })();
            </script>

        @else

            {{-- placeholder premium (o JS preenche se existir localStorage) --}}
            <div id="uc-last-reservation" style="display:none;"></div>

            @if($errors->any())
                <div class="uc-alert uc-alert-danger">
                    <strong>Há campos por corrigir.</strong>
                    <span>Revê os dados assinalados abaixo.</span>
                </div>
            @endif

            <div class="uc-form-wrap">
                <div class="uc-form-card">
                    <form action="{{ route('reservations.store') }}" method="POST" class="uc-form">
                        @csrf

                        <div class="uc-form-grid">

                            <div class="uc-field">
                                <label for="customer_name">Nome</label>
                                <input id="customer_name" name="customer_name" type="text"
                                       value="{{ old('customer_name') }}" autocomplete="name"
                                       placeholder="Ex.: Tiago Monteiro"
                                       class="@error('customer_name') is-invalid @enderror" required>
                                @error('customer_name') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="uc-field">
                                <label for="customer_phone">Telefone</label>
                                <input id="customer_phone" name="customer_phone" type="tel"
                                       value="{{ old('customer_phone') }}" autocomplete="tel"
                                       placeholder="Ex.: 9xx xxx xxx"
                                       class="@error('customer_phone') is-invalid @enderror">
                                @error('customer_phone') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="uc-field">
                                <label for="customer_email">Email</label>
                                <input id="customer_email" name="customer_email" type="email"
                                       value="{{ old('customer_email') }}" autocomplete="email"
                                       placeholder="Ex.: nome@email.com"
                                       class="@error('customer_email') is-invalid @enderror">
                                @error('customer_email') <div class="uc-error">{{ $message }}</div> @enderror
                                <div class="uc-hint">Se indicares email, recebes os detalhes automaticamente.</div>
                            </div>

                            <div class="uc-field">
                                <label for="num_people">Nº de pessoas</label>
                                <input id="num_people" name="num_people" type="number" min="1"
                                       value="{{ old('num_people', 2) }}"
                                       class="@error('num_people') is-invalid @enderror" required>
                                @error('num_people') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="uc-field">
                                <label for="date">Data</label>
                                <input id="date" name="date" type="date"
                                       min="{{ now()->toDateString() }}"
                                       value="{{ old('date') }}"
                                       class="@error('date') is-invalid @enderror" required>
                                @error('date') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="uc-field">
                                <label for="time">Hora</label>
                                <input id="time" name="time" type="time" step="900"
                                       value="{{ old('time') }}"
                                       class="@error('time') is-invalid @enderror" required>
                                @error('time') <div class="uc-error">{{ $message }}</div> @enderror
                                <div class="uc-hint" id="timeHint">Ter–Sex: 16:00–22:30 · Sáb–Dom: 09:00–22:30</div>
                            </div>

                            <div class="uc-field">
                                <label for="table_id">Mesa (opcional)</label>
                                <select id="table_id" name="table_id"
                                        class="uc-select @error('table_id') is-invalid @enderror">
                                    <option value="">Sem preferência</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->id }}" @selected(old('table_id') == $table->id)>
                                            {{ $table->name }}
                                            @if(!is_null($table->capacity))
                                                ({{ $table->capacity }} pax)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('table_id') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="uc-field">
                                <label for="event_id">Evento (opcional)</label>
                                <select id="event_id" name="event_id"
                                        class="uc-select @error('event_id') is-invalid @enderror">
                                    <option value="">Sem evento</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>
                                            {{ $event->title }} — {{ \Illuminate\Support\Carbon::parse($event->date)->format('d/m') }}
                                            @if($event->start_time)
                                                · {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('event_id') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="uc-field uc-field-full">
                                <label for="notes">Observações</label>
                                <textarea id="notes" name="notes" rows="4"
                                          placeholder="Ex.: cadeira de bebé, perto do ecrã, aniversário..."
                                          class="@error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                                @error('notes') <div class="uc-error">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        <div class="uc-form-actions">
                            <button type="submit" class="uc-btn-primary">Confirmar pedido</button>
                            <a href="{{ route('union.home') }}" class="uc-btn-ghost">Voltar ao site</a>
                        </div>
                    </form>
                </div>

                <aside class="uc-side-card">
                    <h3>Dicas rápidas</h3>
                    <ul class="uc-side-list">
                        <li>Em dias de jogo grande, reserva com antecedência.</li>
                        <li>Grupos maiores? Escreve nas observações.</li>
                        <li>Queres uma mesa perto do ecrã? Diz-nos ✨</li>
                    </ul>

                    <div class="uc-side-mini">
                        <div class="uc-side-mini-title">Contacto rápido</div>
                        <div class="uc-side-mini-text">Email: rematedecisivo@gmail.com</div>
                        <div class="uc-side-mini-text">Tel: 912 345 678</div>
                    </div>
                </aside>
            </div>

        @endif

    </div>
</section>
@endsection
