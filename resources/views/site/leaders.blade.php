@extends('layouts.site')

@section('title', 'Leaders | Windsor AI Club')
@section('body_class', 'events-page leaders-page')

@section('content')
  <div class="shell">
    @include('partials.site.header')

    <section class="leaders-hero">
      <h1 data-reveal>Group Leaders</h1>
      <p data-reveal>Meet the students and mentors guiding our labs, research pods, and community events.</p>
    </section>

    <section class="leaders-shell">
      <div class="leaders-grid">
        <div class="leader-card breath" data-reveal>
          <img class="leader-photo" src="{{ asset('images/leaders/hadiyah.png') }}" alt="Hadiyah Arif" loading="lazy" />
          <h3>Hadiyah Arif</h3>
          <span class="leader-role">President</span>
          <p class="leader-focus">Strategy, partnerships, and keeping the club aligned.</p>
          <div class="leader-links">
            <a href="#">LinkedIn</a>
          </div>
          <div class="leader-meta">
            <span class="leader-pill">Leadership</span>
            <span class="leader-pill">Outreach</span>
          </div>
        </div>
        <div class="leader-card breath" data-reveal>
          <img class="leader-photo" src="{{ asset('images/leaders/Yusriyah_Rahman.jpg') }}" alt="Yusriyah Rahman" loading="lazy" />
          <h3>Yusriyah Rahman</h3>
          <span class="leader-role">Vice President</span>
          <p class="leader-focus">Ops, collaboration outreach, and member experience.</p>
          <div class="leader-meta">
            <span class="leader-pill">Operations</span>
            <span class="leader-pill">Community</span>
          </div>
        </div>
        <div class="leader-card breath" data-reveal>
          <img class="leader-photo" src="{{ asset('images/leaders/BobolaObi.jpg') }}" alt="Bobola Obiwale" loading="lazy" />
          <h3>Bobola Obiwale</h3>
          <span class="leader-role">Web Admin</span>
          <p class="leader-focus">Site updates, chatbot activity, polls, and Discord links.</p>
          <div class="leader-links">
            <a href="#">GitHub</a>
          </div>
          <div class="leader-meta">
            <span class="leader-pill">Web</span>
            <span class="leader-pill">Infra</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <img class="leader-photo" src="{{ asset('images/leaders/manhoz.jpg') }}" alt="Mahnoz Akhtari" loading="lazy" />
          <h3>Mahnoz Akhtari</h3>
          <span class="leader-role">Head of Events</span>
          <p class="leader-focus">Clubs Day prep, trivia night planning, and seminar logistics.</p>
          <div class="leader-meta">
            <span class="leader-pill">Events</span>
            <span class="leader-pill">Logistics</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">AA</div>
          <h3>Aleena Azeem</h3>
          <span class="leader-role">Treasurer</span>
          <p class="leader-focus">Funding, requisitions, and financial reporting.</p>
          <div class="leader-meta">
            <span class="leader-pill">Finance</span>
            <span class="leader-pill">Funding</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">MA</div>
          <h3>Muhammad Ali</h3>
          <span class="leader-role">Secretary</span>
          <p class="leader-focus">Minutes, task sheets, and documentation.</p>
          <div class="leader-meta">
            <span class="leader-pill">Ops</span>
            <span class="leader-pill">Docs</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">OE</div>
          <h3>Omar Elkott</h3>
          <span class="leader-role">Head of Communication</span>
          <p class="leader-focus">Comms schedule, AI image generator setup, collaborations.</p>
          <div class="leader-links">
            <a href="#">LinkedIn</a>
          </div>
          <div class="leader-meta">
            <span class="leader-pill">Comms</span>
            <span class="leader-pill">Events</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">AH</div>
          <h3>Abir Hirani</h3>
          <span class="leader-role">Head of Projects</span>
          <p class="leader-focus">Project tracks, weekly breakdowns, and repo handoffs.</p>
          <div class="leader-links">
            <a href="#">GitHub</a>
          </div>
          <div class="leader-meta">
            <span class="leader-pill">Projects</span>
            <span class="leader-pill">MLOps</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">IP</div>
          <h3>Isaac P</h3>
          <span class="leader-role">Head of Research</span>
          <p class="leader-focus">Paper selection, datasets, timelines, and starter repos.</p>
          <div class="leader-meta">
            <span class="leader-pill">Research</span>
            <span class="leader-pill">NLP</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">ST</div>
          <h3>Sadat Tanzim</h3>
          <span class="leader-role">Project Coordinator</span>
          <p class="leader-focus">Tracks execution, workshop flow, and participant support.</p>
          <div class="leader-links">
            <a href="#">GitHub</a>
          </div>
          <div class="leader-meta">
            <span class="leader-pill">Tracks</span>
            <span class="leader-pill">Workshops</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">HZ</div>
          <h3>Hassan Zafar</h3>
          <span class="leader-role">Research Coordinator</span>
          <p class="leader-focus">Prompt engineering activity and research stream support.</p>
          <div class="leader-meta">
            <span class="leader-pill">Research</span>
            <span class="leader-pill">Prompts</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">PP</div>
          <h3>Prushti Patel</h3>
          <span class="leader-role">Research Coordinator</span>
          <p class="leader-focus">Paper sprints, datasets, and schedule alignment.</p>
          <div class="leader-meta">
            <span class="leader-pill">Research</span>
            <span class="leader-pill">Data</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">YS</div>
          <h3>Yumna Sumya</h3>
          <span class="leader-role">Marketing Coordinator</span>
          <p class="leader-focus">Flyers, blue/yellow branding, and promotional cadence.</p>
          <div class="leader-meta">
            <span class="leader-pill">Marketing</span>
            <span class="leader-pill">Brand</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">A</div>
          <h3>Amarjot</h3>
          <span class="leader-role">Content Creator</span>
          <p class="leader-focus">Flyers and content for activities and streams.</p>
          <div class="leader-meta">
            <span class="leader-pill">Content</span>
            <span class="leader-pill">Design</span>
          </div>
        </div>
        <div class="leader-card" data-reveal>
          <div class="leader-photo placeholder">Z</div>
          <h3>Zahra Gurmani</h3>
          <span class="leader-role">Content Creator</span>
          <p class="leader-focus">Flyers and prompt-engineering explainer content.</p>
          <div class="leader-meta">
            <span class="leader-pill">Content</span>
            <span class="leader-pill">Prompts</span>
          </div>
        </div>
      </div>
    </section>
  </div>

  @include('partials.site.footer')
@endsection
