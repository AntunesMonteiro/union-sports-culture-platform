<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Union Sports & Culture')</title>

  <link rel="stylesheet" href="{{ asset('union/css/style.css') }}">
</head>

<body>

  <!-- NAVBAR -->
  <header class="uc-header">
    <div class="uc-container">
      <div class="uc-nav">
        <a class="uc-brand" href="{{ route('union.home') }}">
          <img
            class="uc-logo"
            src="{{ asset('union/img/logo-emblem.png') }}"
            onerror="this.onerror=null;this.src='{{ asset('images/logo-emblem.png') }}';"
            alt="Union Sports & Culture"
          >
          <div class="uc-brand-text">
            <span class="uc-brand-title">UNION</span>
            <span class="uc-brand-sub">SPORTS &amp; CULTURE</span>
          </div>
        </a>

        <nav class="uc-links">
          <a href="{{ route('union.home') }}#sobre">Sobre</a>
          <a href="{{ route('union.home') }}#sports">Sports</a>
          <a href="{{ route('union.home') }}#menu">Menu</a>
          <a href="{{ route('union.home') }}#eventos">Eventos</a>
          <a href="{{ route('union.home') }}#contactos">Contactos</a>
        </nav>

        <div class="uc-nav-actions">
          <a class="uc-social" href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="7" y="7" width="10" height="10" rx="3"></rect>
              <path d="M16.5 7.5h.01"></path>
              <path d="M12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path>
              <path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4z"></path>
            </svg>
          </a>

          <a class="uc-social" href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M14 8h3V5h-3c-2.2 0-4 1.8-4 4v3H7v3h3v6h3v-6h3l1-3h-4V9c0-.6.4-1 1-1z"></path>
              <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"></path>
            </svg>
          </a>

          <button class="uc-burger" id="uc-burger" aria-label="Abrir menu">
            <span></span><span></span><span></span>
          </button>
        </div>
      </div>

      <!-- Mobile nav -->
      <div class="uc-mobile-nav" id="uc-mobile-nav">
        <a href="{{ route('union.home') }}#sobre">Sobre</a>
        <a href="{{ route('union.home') }}#sports">Sports</a>
        <a href="{{ route('union.home') }}#menu">Menu</a>
        <a href="{{ route('union.home') }}#eventos">Eventos</a>
        <a href="{{ route('union.home') }}#contactos">Contactos</a>

        <div class="uc-mobile-social" style="display:flex; gap:10px; padding-top:10px;">
          <a class="uc-social" href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="7" y="7" width="10" height="10" rx="3"></rect>
              <path d="M16.5 7.5h.01"></path>
              <path d="M12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path>
              <path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4z"></path>
            </svg>
          </a>

          <a class="uc-social" href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M14 8h3V5h-3c-2.2 0-4 1.8-4 4v3H7v3h3v6h3v-6h3l1-3h-4V9c0-.6.4-1 1-1z"></path>
              <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"></path>
            </svg>
          </a>
        </div>
      </div>

    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer class="uc-footer" id="contactos">
    <div class="uc-container">
      <div class="uc-footer-grid">

        <div>
          <div class="uc-footer-logo">
            <img
              src="{{ asset('union/img/logo-emblem.png') }}"
              onerror="this.onerror=null;this.src='{{ asset('images/logo-emblem.png') }}';"
              alt="Union Sports & Culture"
            >
            <div>
              <div class="uc-footer-title">UNION</div>
              <div class="uc-footer-subtitle">SPORTS &amp; CULTURE</div>
            </div>
          </div>

          <p class="uc-footer-text" style="margin-top:12px;">
            O teu spot em Fernão Ferro para ver jogos, jantar e viver eventos.
          </p>
        </div>

        <div>
          <div class="uc-footer-heading">Contactos</div>
          <p class="uc-footer-text" style="margin-bottom:8px;">Fernão Ferro, Seixal</p>
          <p class="uc-footer-text" style="margin-bottom:8px;">Email: rematedecisivo@gmail.com</p>
          <p class="uc-footer-text" style="margin-bottom:0;">Tel: 912 345 678</p>
        </div>

      </div>

      <div class="uc-footer-bottom">
        <div class="uc-footer-bottom-inner">
          <span>© {{ date('Y') }} Union Sports &amp; Culture</span>
          <span>made by STELLS DESIGNER</span>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ asset('union/js/main.js') }}"></script>
</body>
</html>
