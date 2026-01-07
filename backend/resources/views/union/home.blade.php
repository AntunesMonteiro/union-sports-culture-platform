@extends('layouts.union')

@section('title', 'Union Sports & Culture')

@section('content')

  <section class="uc-hero" id="topo">
    <div class="uc-hero-bg">
      <img
        src="{{ asset('union/img/hero-bg.jpg') }}"
        onerror="this.onerror=null;this.src='{{ asset('images/hero-bg.jpg') }}';"
        alt="Union Sports & Culture"
      >
    </div>

    <div class="uc-container">
      <div class="uc-hero-inner">
        <div class="uc-hero-copy">
          <p class="uc-kicker">SPORTS · CULTURA · FAMÍLIA</p>

          <h1 class="uc-hero-title">
            O teu novo spot em <span class="uc-accent">Fernão Ferro</span>
          </h1>

          <p class="uc-hero-text">
            Onde o desporto e a cultura se unem: jogos em ecrãs gigantes, eventos ao vivo,
            hambúrgueres, hot dogs, tartines e um espaço kids para famílias e amigos.
          </p>

          <div class="uc-hero-actions">
            <a class="uc-btn" href="{{ route('reservations.create') }}">Reservar mesa</a>
            <a class="uc-btn-ghost" href="#menu">Ver menu</a>
          </div>

          <div class="uc-hero-tags">
            <span>Sports Bar</span>
            <span>Eventos &amp; Cultura</span>
            <span>Famílias &amp; Kids</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- SOBRE --}}
  <section id="sobre" class="uc-section uc-section-alt">
    <div class="uc-container uc-grid-2">
      <div>
        <p class="uc-kicker">A nossa história</p>
        <h2>Sobre o Union Sports &amp; Culture</h2>
        <p>
          O Union é um espaço descontraído em Fernão Ferro pensado para famílias, grupos de
          amigos e amantes de desporto. Ambiente acolhedor, opções para todas as idades e
          muita animação ao longo da semana.
        </p>
        <ul class="uc-list">
          <li>TV gigante e várias televisões para seguires todos os jogos.</li>
          <li>Eventos ao vivo, música, quizzes e stand-up.</li>
          <li>Espaço kids para os mais novos se divertirem em segurança.</li>
          <li>Hambúrgueres, hot dogs e tartines com assinatura da casa.</li>
        </ul>
      </div>

      <div class="uc-image-card">
        <img src="{{ asset('union/img/barUnion.jpg') }}" alt="Interior do Union Sports & Culture">
      </div>
    </div>
  </section>

  {{-- SPORTS --}}
  <section id="sports" class="uc-section">
    <div class="uc-container">
      <p class="uc-kicker">Sports</p>
      <h2>Jogos como se estivesses na bancada</h2>
      <p class="uc-section-intro">
        Liga Portugal, Champions, Premier League e muito mais. Também acompanhamos MotoGP,
        desportos de combate e outros eventos desportivos especiais.
      </p>

      <div class="uc-grid-3">
        <div class="uc-card">
          <img src="{{ asset('union/img/sports-football.jpg') }}" alt="Futebol" class="uc-card-img">
          <h3>Futebol ao mais alto nível</h3>
          <p>Os grandes jogos em ecrã gigante e som ambiente dedicado.</p>
        </div>
        <div class="uc-card">
          <img src="{{ asset('union/img/sports-motogp.jpg') }}" alt="MotoGP" class="uc-card-img">
          <h3>Outros desportos</h3>
          <p>MotoGP, desportos de combate e mais, sempre que há grande espetáculo.</p>
        </div>
        <div class="uc-card">
          <img src="{{ asset('union/img/sports-friends.jpg') }}" alt="Amigos a ver jogo" class="uc-card-img">
          <h3>Ambiente Union</h3>
          <p>Um spot de bairro com vibe de arena: perfeito para vibrar em grupo.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- MENU --}}
  <section id="menu" class="uc-section uc-section-alt">
    <div class="uc-container">
      <p class="uc-kicker">Menu</p>
      <h2>Comida e bebida para acompanhar o jogo</h2>
      <p class="uc-section-intro">
        Um menu simples e saboroso: hambúrgueres, hot dogs, tartines, snacks e boas bebidas.
      </p>

      <div class="uc-grid-3">
        <div class="uc-menu-card">
          <img src="{{ asset('union/img/menu-bar.jpg') }}" alt="Bar" class="uc-menu-img">
          <h3>Bar</h3>
          <p>Imperiais, cerveja em garrafa, sidras, vinhos e cocktails clássicos.</p>
        </div>
        <div class="uc-menu-card">
          <img src="{{ asset('union/img/menu-food.jpg') }}" alt="Comida" class="uc-menu-img">
          <h3>Comida</h3>
          <p>Hambúrgueres, hot dogs, tartines, tostas, pregos e muito mais.</p>
        </div>
        <div class="uc-menu-card">
          <img src="{{ asset('union/img/menu-happy-hour.jpg') }}" alt="Snacks" class="uc-menu-img">
          <h3>Snacks &amp; happy hour</h3>
          <p>Nachos, batatas, molhos e petiscos perfeitos para partilhar.</p>
        </div>
      </div>

      <div class="uc-menu-note">
        Em breve: menus especiais “Noite de jogo” e “Brunch Union”.
      </div>
    </div>
  </section>

  {{-- EVENTOS --}}
  <section id="eventos" class="uc-section">
    <div class="uc-container">
      <p class="uc-kicker">Eventos &amp; Cultura</p>
      <h2>Noites com mais do que jogo</h2>
      <p class="uc-section-intro">
        Música ao vivo, quizzes, fados, stand-up e mini exposições de artistas locais.
      </p>

      <div class="uc-events-grid">
        <div class="uc-event-card">
          <img src="{{ asset('union/img/event-live-music.jpg') }}" alt="Música ao vivo">
          <h3>Música ao vivo</h3>
          <p>Noites com bandas e artistas que trazem ainda mais energia ao espaço.</p>
        </div>
        <div class="uc-event-card">
          <img src="{{ asset('union/img/event-local-art.jpg') }}" alt="Arte local">
          <h3>Arte &amp; comunidade</h3>
          <p>Mini exposições e iniciativas com talentos da Margem Sul.</p>
        </div>
      </div>

      @if($events->count())
        <div class="uc-upcoming">
          <h3>Próximos eventos</h3>
          <ul>
            @foreach($events as $event)
              <li>
                <strong>{{ $event->title }}</strong>
                — {{ \Illuminate\Support\Carbon::parse($event->date)->format('d/m') }}
                @if($event->start_time)
                  · {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }}
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
  </section>

@endsection
