@extends('layouts.site')

@section('title', 'Events | Windsor AI Club')
@section('body_class', 'events-page')

@section('content')
  <div class="events-hero">
    @include('partials.site.header', ['header_class' => 'events-nav'])
    <div class="events-hero-content" data-reveal>
      <a class="back-link" href="{{ route('home') }}" data-reveal>← Back</a>
      <h1 data-reveal>Events</h1>
      <p class="events-season" data-reveal>Upcoming &amp; recent</p>
    </div>
    <div class="events-hero-figure"></div>
  </div>

  <div class="events-shell">
    <div class="event-list">
      <div class="event-row" data-reveal role="button" tabindex="0"
           data-title="Mini Jarvis Workshop"
           data-start="2026-01-16T17:00:00"
           data-end="2026-01-16T20:00:00"
           data-location="Toledo Health Education CTR 102"
           data-description="Build your own voice-powered AI assistant with Python.">
        <div>
          <h3>Mini Jarvis Workshop <span>Toledo Health Education CTR 102</span></h3>
          <p>Build your own voice-powered AI assistant with Python.</p>
        </div>
        <div class="event-date breath">Jan 16, 2026 · 5:00–8:00 PM</div>
      </div>
      <div class="event-row" data-reveal role="button" tabindex="0"
           data-title="ML Learning Workshop"
           data-start="2026-03-19T11:30:00"
           data-end="2026-03-19T13:00:00"
           data-location="Dillon Hall 255"
           data-description="Hands-on ML learning session (bring a laptop).">
        <div>
          <h3>ML Learning Workshop <span>Dillon Hall 255</span></h3>
          <p>Hands-on ML learning session (bring a laptop).</p>
        </div>
        <div class="event-date breath">Mar 19 · 11:30 AM–1:00 PM</div>
      </div>
      <div class="event-row" data-reveal role="button" tabindex="0"
           data-title="AI and Autonomous Technologies on Future Societies"
           data-start="2026-03-22T12:00:00"
           data-end="2026-03-22T13:00:00"
           data-location="300 Ouellette Avenue"
           data-description="Speaker: Nour Elkott. Talk and discussion.">
        <div>
          <h3>AI and Autonomous Technologies on Future Societies <span>Speaker: Nour Elkott</span></h3>
          <p>Talk and discussion at 300 Ouellette Avenue.</p>
        </div>
        <div class="event-date breath">Mar 22 · 12:00–1:00 PM</div>
      </div>
      <div class="event-row" data-reveal role="button" tabindex="0"
           data-title="Introduction to Python Workshop"
           data-start="2026-07-29T19:00:00"
           data-end="2026-07-29T20:00:00"
           data-location="Online"
           data-description="Led by Matthew Muscedere (AI Club President).">
        <div>
          <h3>Introduction to Python Workshop <span>Online</span></h3>
          <p>Led by Matthew Muscedere (AI Club President).</p>
        </div>
        <div class="event-date breath">Jul 29 · 7:00–8:00 PM</div>
      </div>
      <div class="event-row" data-reveal role="button" tabindex="0"
           data-title="ML Model Training Workshop"
           data-start="2026-07-30T19:00:00"
           data-end="2026-07-30T20:00:00"
           data-location="Online"
           data-description="Led by Gabriel Rueda.">
        <div>
          <h3>ML Model Training Workshop <span>Online</span></h3>
          <p>Led by Gabriel Rueda.</p>
        </div>
        <div class="event-date breath">Jul 30 · 7:00–8:00 PM</div>
      </div>
    </div>
  </div>

  <div class="modal" id="eventModal" hidden>
    <div class="modal-backdrop" data-close></div>
    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="eventModalTitle">
      <button class="modal-close" type="button" data-close aria-label="Close">×</button>
      <h2 id="eventModalTitle"></h2>
      <p class="modal-sub" id="eventModalWhen"></p>
      <p class="modal-sub" id="eventModalWhere"></p>
      <p class="modal-desc" id="eventModalDesc"></p>
      <div class="modal-actions">
        <a class="btn primary breath" id="eventModalGoogle" href="#" target="_blank" rel="noreferrer">Add to Google Calendar</a>
        <a class="btn secondary" id="eventModalIcs" href="#" download>Download .ics</a>
      </div>
    </div>
  </div>

  @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

@push('scripts')
  <script>
    const CAL_TZ = 'America/Toronto';
    const modal = document.getElementById('eventModal');
    const titleEl = document.getElementById('eventModalTitle');
    const whenEl = document.getElementById('eventModalWhen');
    const whereEl = document.getElementById('eventModalWhere');
    const descEl = document.getElementById('eventModalDesc');
    const googleEl = document.getElementById('eventModalGoogle');
    const icsEl = document.getElementById('eventModalIcs');

    function pad2(value) {
      return String(value).padStart(2, '0');
    }

    function formatLocalCompact(date) {
      return `${date.getFullYear()}${pad2(date.getMonth() + 1)}${pad2(date.getDate())}T${pad2(date.getHours())}${pad2(date.getMinutes())}${pad2(date.getSeconds())}`;
    }

    function formatUtcCompact(date) {
      return date.toISOString().replace(/[-:]/g, '').replace(/\\.\\d{3}Z$/, 'Z');
    }

    function buildGoogleUrl({ title, startLocal, endLocal, description, location }) {
      const dates = `${formatLocalCompact(startLocal)}/${formatLocalCompact(endLocal)}`;
      const params = new URLSearchParams({
        action: 'TEMPLATE',
        text: title,
        dates,
        details: description || '',
        location: location || '',
        ctz: CAL_TZ
      });
      return `https://calendar.google.com/calendar/render?${params.toString()}`;
    }

    function buildICS({ title, startLocal, endLocal, description, location }) {
      const now = new Date();
      const uuid = window.crypto && window.crypto.randomUUID ? window.crypto.randomUUID() : null;
      const uid = uuid ? uuid : `${now.getTime()}@uwindsorai.club`;
      const lines = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//Windsor AI Club//Events//EN',
        'CALSCALE:GREGORIAN',
        'METHOD:PUBLISH',
        'BEGIN:VEVENT',
        `UID:${uid}`,
        `DTSTAMP:${formatUtcCompact(now)}`,
        `DTSTART:${formatUtcCompact(startLocal)}`,
        `DTEND:${formatUtcCompact(endLocal)}`,
        `SUMMARY:${(title || '').replace(/\\n/g, ' ')}`,
        `DESCRIPTION:${(description || '').replace(/\\n/g, ' ')}`,
        `LOCATION:${(location || '').replace(/\\n/g, ' ')}`,
        'END:VEVENT',
        'END:VCALENDAR'
      ];
      return `${lines.join('\\r\\n')}\\r\\n`;
    }

    function openModal(data, dateText) {
      const title = data.title || '';
      const start = data.start || '';
      const end = data.end || '';
      const description = data.description || '';
      const location = data.location || '';

      const startLocal = new Date(start);
      const endLocal = new Date(end);

      titleEl.textContent = title;
      whenEl.textContent = dateText || '';
      whereEl.textContent = location ? `Location: ${location}` : '';
      descEl.textContent = description || '';

      googleEl.href = buildGoogleUrl({ title, startLocal, endLocal, description, location });

      const ics = buildICS({ title, startLocal, endLocal, description, location });
      const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' });
      icsEl.href = URL.createObjectURL(blob);
      icsEl.download = `${title || 'event'}.ics`.replace(/[^\\w\\- ]+/g, '').trim().replace(/\\s+/g, '-');

      modal.hidden = false;
      document.body.classList.add('modal-open');
      (modal.querySelector('.modal-close') || modal).focus();
    }

    function closeModal() {
      if (modal.hidden) return;
      modal.hidden = true;
      document.body.classList.remove('modal-open');
    }

    function formatWhen(row) {
      const start = row.getAttribute('data-start') || '';
      const end = row.getAttribute('data-end') || '';
      if (!start || !end) return '';
      const startDate = new Date(start);
      const endDate = new Date(end);
      const datePart = startDate.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
      const timePart = `${startDate.toLocaleTimeString(undefined, { hour: 'numeric', minute: '2-digit' })}–${endDate.toLocaleTimeString(undefined, { hour: 'numeric', minute: '2-digit' })}`;
      return `${datePart} · ${timePart}`;
    }

    function rowData(row) {
      return {
        title: row.getAttribute('data-title') || '',
        start: row.getAttribute('data-start') || '',
        end: row.getAttribute('data-end') || '',
        location: row.getAttribute('data-location') || '',
        description: row.getAttribute('data-description') || ''
      };
    }

    document.querySelectorAll('.event-row').forEach((row) => {
      row.addEventListener('click', () => openModal(rowData(row), formatWhen(row)));
      row.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          openModal(rowData(row), formatWhen(row));
        }
      });
    });

    modal.querySelectorAll('[data-close]').forEach((node) => node.addEventListener('click', closeModal));
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeModal();
    });
  </script>
@endpush
