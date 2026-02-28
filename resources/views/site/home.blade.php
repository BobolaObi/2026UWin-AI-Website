@extends('layouts.site')

@section('title', 'Windsor AI Club')
@section('body_class', 'home-page')

@section('content')
  <div class="shell">
    @include('partials.site.header')

    <section class="hero" id="events">
      <div class="hero-grid">
        <div class="hero-copy">
          <div class="eyebrow" data-reveal>Campus-made &amp; community-ready</div>
          <h1 data-reveal>A place to build real <br/> AI projects.</h1>
          <p class="sub" data-reveal>
            A student-led AI community at the University of Windsor. Join our community of over 500 AI enthusiasts and practitioners — we explore cutting-edge technologies, share knowledge, and build the future together.
          </p>

          <div class="actions" data-reveal>
            <a class="btn primary breath" id="joinBtn" href="{{ route('join') }}">Join the Club</a>
            <a class="btn secondary" href="{{ route('events') }}">View Events</a>
          </div>

          <div class="meta" data-reveal>
            <span class="pill">500+ members</span>
            <span class="pill soft">Hands-on labs &amp; workshops</span>
            <span class="pill soft">Active projects</span>
          </div>
        </div>

        <div class="hero-visual" id="heroVisual" data-reveal>
          <a class="floating-label pop-tag" href="https://www.instagram.com/uwindsor.ai.club/" target="_blank" rel="noopener noreferrer">
            @uwindsor.ai.club
          </a>
          <div class="card-band">
            <div class="event-strip" id="eventStrip" aria-label="Latest event highlights"></div>
          </div>
          <a class="floating-label pop-tag right" href="https://www.linkedin.com/company/uwindsor-ai-club" target="_blank" rel="noopener noreferrer">
            LinkedIn · uwindsor-ai-club
          </a>
        </div>
      </div>
    </section>
  </div>

  @include('partials.site.footer')
@endsection

@push('scripts')
  <script>
    const events = [
      { title: 'Mini Jarvis Workshop', date: 'Jan 16, 2026', image: 'images/IMG_3822.jpg', tag: 'Mini Jarvis' },
      { title: 'Mini Jarvis Workshop', date: 'Jan 16, 2026', image: 'images/IMG_3815.jpg', tag: 'Hands-on' },
      { title: 'Workshop night', date: 'Jan 2026', image: 'images/IMG_2762.jpg', tag: 'Build night' },
      { title: 'Workshop night', date: 'Jan 2026', image: 'images/IMG_2766.jpg', tag: 'In-person' },
      { title: 'Collaboration event', date: 'Jan 2026', image: 'images/A successful event in collaboration with @uwindsor.ai.club . Thank you to everyone who joined us.jpg', tag: 'Collab' },
      { title: 'Collaboration event', date: 'Jan 2026', image: 'images/A successful event in collaboration with @uwindsor.ai.club . Thank you to everyone who joined us-2.jpg', tag: 'Community' }
    ];

    const strip = document.getElementById('eventStrip');
    const latestFive = events.slice(-5);
    const centerIndex = (latestFive.length - 1) / 2;
    const cards = [];

    latestFive.forEach((event, index) => {
      const card = document.createElement('div');
      card.className = 'event-card';
      const rotation = (index - centerIndex) * 4;
      const z = Math.round(10 - Math.abs(index - centerIndex));
      card.style.setProperty('--card-rotation', `${rotation}deg`);
      card.style.setProperty('--float-delay', `${index * 0.35}s`);
      card.style.setProperty('--z', `${z}`);
      card.style.backgroundImage = `url("${encodeURI(event.image)}")`;

      const overlay = document.createElement('div');
      overlay.className = 'event-overlay';

      const tag = document.createElement('span');
      tag.className = 'pill bubble';
      tag.textContent = event.tag;

      const meta = document.createElement('div');
      meta.className = 'event-meta';
      meta.innerHTML = `<p>${event.title}</p><span>${event.date}</span>`;

      overlay.appendChild(tag);
      overlay.appendChild(meta);
      card.appendChild(overlay);
      strip.appendChild(card);
      cards.push(card);
    });

    const setDockHover = (activeIndex) => {
      strip.classList.add('is-active');
      cards.forEach((card, i) => {
        card.classList.toggle('is-hovered', i === activeIndex);
        card.classList.toggle('is-near', Math.abs(i - activeIndex) === 1);
      });
    };

    const clearDockHover = () => {
      strip.classList.remove('is-active');
      cards.forEach((card) => {
        card.classList.remove('is-hovered', 'is-near');
      });
    };

    cards.forEach((card, index) => {
      card.addEventListener('mouseenter', () => setDockHover(index));
      card.addEventListener('focus', () => setDockHover(index));
      card.addEventListener('mouseleave', clearDockHover);
      card.addEventListener('blur', clearDockHover);
    });
    strip.addEventListener('mouseleave', clearDockHover);

    const heroVisual = document.getElementById('heroVisual');
    const joinBtn = document.getElementById('joinBtn');
    const PIN_DURATION_MS = 60000;
    const HIDE_DELAY_MS = 60000;
    let pinnedUntilMs = 0;
    let hideTimer = null;

    const showTags = (pin = false) => {
      if (hideTimer) {
        clearTimeout(hideTimer);
        hideTimer = null;
      }
      heroVisual.classList.add('show-tags');
      if (pin) pinnedUntilMs = Date.now() + PIN_DURATION_MS;
    };
    const hideTags = () => {
      heroVisual.classList.remove('show-tags');
      pinnedUntilMs = 0;
    };
    const isPinned = () => pinnedUntilMs && Date.now() < pinnedUntilMs;
    const scheduleHide = () => {
      if (hideTimer) clearTimeout(hideTimer);
      hideTimer = setTimeout(() => {
        if (!isPinned()) hideTags();
      }, HIDE_DELAY_MS);
    };

    joinBtn.addEventListener('mouseenter', () => showTags(false));
    joinBtn.addEventListener('focus', () => showTags(false));
    joinBtn.addEventListener('mouseleave', scheduleHide);
    joinBtn.addEventListener('blur', scheduleHide);

    joinBtn.addEventListener('click', (e) => {
      if (!heroVisual.classList.contains('show-tags')) {
        e.preventDefault();
        showTags(true);
      } else if (!isPinned()) {
        e.preventDefault();
        showTags(true);
      }
    });

    document.addEventListener('click', (e) => {
      if (!heroVisual.classList.contains('show-tags')) return;
      const target = e.target;
      if (!(target instanceof Element)) return;
      if (heroVisual.contains(target) || joinBtn.contains(target)) return;
      hideTags();
    });
  </script>
@endpush
