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
      @forelse ($events as $event)
        @php
          $location_text = $event->location ?: '';
          $description_text = $event->description ?: '';
          $date_label = $event->starts_at
              ? $event->starts_at->timezone(config('app.timezone'))->format('M j, Y')
              : '';
          $time_label = ($event->starts_at && $event->ends_at)
              ? $event->starts_at->timezone(config('app.timezone'))->format('g:i A').'–'.$event->ends_at->timezone(config('app.timezone'))->format('g:i A')
              : '';
          $pill_label = trim($date_label.($time_label !== '' ? " · {$time_label}" : ''));
        @endphp
        <div class="event-row" data-reveal role="button" tabindex="0"
             data-title="{{ $event->title }}"
             data-start="{{ $event->starts_at?->timezone(config('app.timezone'))->toIso8601String() }}"
             data-end="{{ $event->ends_at?->timezone(config('app.timezone'))->toIso8601String() }}"
             data-location="{{ $location_text }}"
             data-description="{{ $description_text }}">
          <div>
            <h3>{{ $event->title }} @if ($location_text !== '') <span>{{ $location_text }}</span> @endif</h3>
            @if ($description_text !== '')
              <p>{{ $description_text }}</p>
            @endif
          </div>
          <div class="event-date breath">{{ $pill_label }}</div>
        </div>
      @empty
        <div class="panel-card" data-reveal>
          <div class="panel-kicker">No events yet</div>
          <p class="sub" style="margin:0;">Check back soon, or join the Discord for announcements.</p>
          <div class="panel-actions" style="margin-top:12px;">
            <a class="btn primary breath" href="{{ route('join') }}">Join</a>
          </div>
        </div>
      @endforelse
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
