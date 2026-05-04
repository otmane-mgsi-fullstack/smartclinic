@extends('patient::dashboard.layout')

@section('title', 'Prendre un rendez-vous')

@section('content')

    <style>
        :root {
            --bg:      #f7f9fc;
            --surface: #ffffff;
            --border:  #e8ecf2;
            --text:    #0e1726;
            --muted:   #6b7a99;
            --hint:    #a0acc4;
            --blue:    #1a56db;
            --blue-lt: #eef3ff;
            --blue-md: #93b4f8;
            --green:   #047857;
            --green-lt:#ecfdf5;
            --red:     #be123c;
            --red-lt:  #fff1f3;
            --amber:   #92400e;
            --amber-lt:#fffbeb;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        .rdv-page {
            background: var(--bg);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: var(--text);
            padding: 32px 24px 64px;
        }

        /* ── Header ── */
        .rdv-header {
            max-width: 1100px;
            margin: 0 auto 32px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .rdv-back {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            padding: 6px 12px;
            border: .5px solid var(--border);
            border-radius: 8px;
            background: var(--surface);
            transition: color .15s;
        }
        .rdv-back:hover { color: var(--blue); }
        .rdv-back svg { width: 14px; height: 14px; }
        .rdv-header h1 { font-size: 20px; font-weight: 500; }
        .rdv-header p  { font-size: 13px; color: var(--muted); margin-top: 2px; }

        /* ── Stepper ── */
        .stepper {
            max-width: 1100px;
            margin: 0 auto 32px;
            display: flex;
            align-items: center;
            gap: 0;
        }
        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }
        .step-num {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 500;
            flex-shrink: 0;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--muted);
        }
        .step.active .step-num  { background: var(--blue); border-color: var(--blue); color: #fff; }
        .step.done .step-num    { background: var(--green-lt); border-color: var(--green); color: var(--green); }
        .step-label { font-size: 13px; color: var(--muted); }
        .step.active .step-label { color: var(--text); font-weight: 500; }
        .step.done .step-label   { color: var(--green); }
        .step-line {
            flex: 1;
            height: 1px;
            background: var(--border);
            margin: 0 12px;
            max-width: 60px;
        }

        /* ── Layout ── */
        .rdv-layout {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: .5px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-title svg { width: 16px; height: 16px; color: var(--blue); }

        /* ── Specialité filter ── */
        .spec-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }
        .spec-pill {
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 13px;
            border: .5px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            cursor: pointer;
            transition: all .15s;
        }
        .spec-pill:hover   { border-color: var(--blue-md); color: var(--blue); }
        .spec-pill.active  { background: var(--blue-lt); border-color: var(--blue-md); color: var(--blue); font-weight: 500; }

        /* ── Médecins ── */
        .medecin-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .medecin-card {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 16px;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
            background: var(--surface);
            position: relative;
        }
        .medecin-card:hover  { border-color: var(--blue-md); }
        .medecin-card.selected {
            border-color: var(--blue);
            background: var(--blue-lt);
        }
        .medecin-card.selected .check-mark { display: flex; }
        .check-mark {
            display: none;
            position: absolute;
            top: 12px;
            right: 12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--blue);
            align-items: center;
            justify-content: center;
        }
        .check-mark svg { width: 11px; height: 11px; fill: #fff; }
        .med-top { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
        .med-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 500;
            flex-shrink: 0;
        }
        .av-blue   { background: var(--blue-lt); color: var(--blue); }
        .av-green  { background: var(--green-lt); color: var(--green); }
        .av-amber  { background: var(--amber-lt); color: var(--amber); }
        .av-red    { background: var(--red-lt); color: var(--red); }
        .med-name  { font-size: 14px; font-weight: 500; color: var(--text); }
        .med-spec  { font-size: 12px; color: var(--muted); margin-top: 1px; }
        .med-meta  { display: flex; flex-wrap: wrap; gap: 6px; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 99px;
            font-weight: 500;
        }
        .badge svg { width: 10px; height: 10px; }
        .badge-green { background: var(--green-lt); color: var(--green); }
        .badge-blue  { background: var(--blue-lt);  color: var(--blue); }
        .badge-amber { background: var(--amber-lt); color: var(--amber); }
        .badge-muted { background: #f1f3f8; color: var(--muted); }
        .med-slots { margin-top: 10px; padding-top: 10px; border-top: .5px solid var(--border); }
        .slots-label { font-size: 11px; color: var(--hint); margin-bottom: 6px; }
        .slots-row { display: flex; flex-wrap: wrap; gap: 5px; }
        .slot {
            font-size: 12px;
            padding: 3px 9px;
            border-radius: 6px;
            border: .5px solid var(--border);
            color: var(--muted);
            background: var(--bg);
            cursor: pointer;
            transition: all .12s;
        }
        .slot:hover  { border-color: var(--blue-md); color: var(--blue); background: var(--blue-lt); }
        .slot.taken  { opacity: .4; cursor: not-allowed; text-decoration: line-through; }

        /* ── Calendrier ── */
        .calendar { width: 100%; }
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .cal-title { font-size: 14px; font-weight: 500; }
        .cal-nav {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: .5px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
        }
        .cal-nav:hover { color: var(--blue); border-color: var(--blue-md); }
        .cal-nav svg { width: 14px; height: 14px; }
        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .cal-day-name {
            font-size: 11px;
            color: var(--hint);
            text-align: center;
            padding: 4px 0;
            font-weight: 500;
        }
        .cal-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border-radius: 8px;
            cursor: pointer;
            color: var(--muted);
            transition: all .12s;
        }
        .cal-day:hover        { background: var(--blue-lt); color: var(--blue); }
        .cal-day.today        { font-weight: 500; color: var(--text); border: 1.5px solid var(--border); }
        .cal-day.selected     { background: var(--blue); color: #fff; font-weight: 500; }
        .cal-day.has-slot     { color: var(--text); }
        .cal-day.no-slot      { opacity: .35; cursor: not-allowed; }
        .cal-day.empty        { cursor: default; }
        .cal-day.empty:hover  { background: transparent; }

        /* ── Motif ── */
        .motif-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .motif-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: var(--text);
            transition: all .12s;
        }
        .motif-item:hover   { border-color: var(--blue-md); }
        .motif-item.selected{ border-color: var(--blue); background: var(--blue-lt); color: var(--blue); font-weight: 500; }
        .motif-icon { font-size: 18px; }
        .motif-radio {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            margin-left: auto;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .motif-item.selected .motif-radio {
            background: var(--blue);
            border-color: var(--blue);
        }
        .motif-item.selected .motif-radio::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
        }

        /* ── Note textarea ── */
        .note-area {
            width: 100%;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--text);
            border: .5px solid var(--border);
            border-radius: 8px;
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
            background: var(--bg);
            margin-top: 12px;
        }
        .note-area:focus { outline: none; border-color: var(--blue-md); }
        .note-area::placeholder { color: var(--hint); }

        /* ── Récapitulatif ── */
        .recap-card {
            background: var(--surface);
            border: .5px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            position: sticky;
            top: 24px;
        }
        .recap-title { font-size: 14px; font-weight: 500; margin-bottom: 20px; }
        .recap-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: .5px solid var(--border);
        }
        .recap-row:last-of-type { border-bottom: none; }
        .recap-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--blue-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .recap-icon svg { width: 15px; height: 15px; color: var(--blue); }
        .recap-label { font-size: 11px; color: var(--hint); margin-bottom: 2px; }
        .recap-val   { font-size: 13px; font-weight: 500; color: var(--text); }
        .recap-empty { font-size: 13px; color: var(--hint); font-style: italic; }

        .btn-primary {
            width: 100%;
            padding: 13px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 20px;
            transition: opacity .15s;
            font-family: inherit;
        }
        .btn-primary:hover { opacity: .88; }
        .btn-primary:disabled { opacity: .4; cursor: not-allowed; }

        .recap-disclaimer {
            font-size: 11px;
            color: var(--hint);
            text-align: center;
            margin-top: 12px;
            line-height: 1.6;
        }

        /* ── Confirmation banner ── */
        .confirm-banner {
            display: none;
            max-width: 1100px;
            margin: 0 auto 24px;
            background: var(--green-lt);
            border: .5px solid #6ee7b7;
            border-radius: 10px;
            padding: 16px 20px;
            align-items: center;
            gap: 14px;
        }
        .confirm-banner svg { width: 22px; height: 22px; color: var(--green); flex-shrink: 0; }
        .confirm-banner p   { font-size: 14px; color: var(--green); font-weight: 500; }
        .confirm-banner span{ font-size: 13px; color: #059669; display: block; margin-top: 2px; }



        /* ── Slots grid ── */
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1rem;
        }


        .slot-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 1rem 1.1rem;

            display: flex;
            flex-direction: column;
            gap: .75rem;

            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all .2s ease;

            position: relative;
        }
        .slot-card:checked{
            background-color: #0d9488;
        }
        .slot-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: #93c5fd;
        }

        /* barre latérale type agenda */
        .slot-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 12px;
            bottom: 12px;
            width: 4px;
            border-radius: 6px;
            background: #3b82f6;
        }

        /* header créneau */
        .slot-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: .75rem;
        }

        /* heure style Doctolib */
        .slot-time {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
        }

        /* date discrète */
        .slot-date {
            font-size: .8rem;
            color: #6b7280;
            margin-top: .15rem;
        }

    </style>




    <div class="rdv-page">

        {{-- ── Confirmation banner ── --}}
        <div class="confirm-banner" id="confirmBanner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p>Rendez-vous confirmé !</p>
                <span>Un SMS de confirmation a été envoyé à votre numéro enregistré.</span>
            </div>
        </div>

        {{-- ── Header ── --}}
        <div class="rdv-header">
            <a href="#" class="rdv-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour
            </a>
            <div>
                <h1>Prendre un rendez-vous</h1>
                <p>Choisissez un médecin disponible et réservez votre créneau</p>
            </div>
        </div>

        {{-- ── Stepper ── --}}
        <div class="stepper">
            <div class="step {{ !$selectedMedecin ? 'active' : '' }}">
                <div class="step-num">1</div>
                <div class="step-label">Médecin</div>
            </div>
            <div class="step-line"></div>
            <div class="step {{ $selectedMedecin && !$selectedDispo ? 'active' : '' }}">
                <div class="step-num">2</div>
                <div class="step-label">Date &amp; heure</div>
            </div>
            <div class="step-line"></div>
            <div class="step {{ $selectedDispo ? 'active' : '' }}">
                <div class="step-num">3</div>
                <div class="step-label">Motif</div>
            </div>
        </div>

        <div class="rdv-layout">

            {{-- ── Colonne GAUCHE ── --}}
            <div>
                {{-- 1. Filtrer par spécialité --}}
                <div class="card">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        Spécialités
                    </div>
                    <div class="spec-list">
                        <a href="{{ route('rdv.index') }}" class="spec-pill {{ !request('spec') ? 'active' : '' }}">Tous</a>
                        @foreach($medecins->unique('specialite') as $m)
                            <span class="spec-pill">{{ $m->specialite }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Médecins disponibles --}}
                <div class="card">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Médecins disponibles
                    </div>

                    <div class="medecin-grid">
                        @foreach($medecins as $medecin)
                            <a href="{{ route('rdv.index', ['medecin_id' => $medecin->id, 'motif' => request('motif')]) }}"
                               class="medecin-card {{ (optional($selectedMedecin)->id == $medecin->id) ? 'selected' : '' }}"
                               style="text-decoration:none; color:inherit;">
                                <div class="med-top">
                                    <div class="med-avatar av-red">{{ substr($medecin->user->name, 0, 1) }}</div>
                                    <div>
                                        <div class="med-name">Dr. {{ $medecin->user->name }}</div>
                                        <div class="med-spec">{{ $medecin->specialite }}</div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 3. Créneaux --}}
                <div class="card">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        Créneaux disponibles
                    </div>

                    <div class="slots-grid">
                        @forelse($disponibilites as $dispo)
                            <a href="{{ route('rdv.index', ['medecin_id' => optional($selectedMedecin)->id, 'dispo' => $dispo->id, 'motif' => request('motif')]) }}"
                               class="slot-card {{ (optional($selectedDispo)->id == $dispo->id) ? 'selected' : '' }}"
                               style="text-decoration:none; color:inherit;">
                                <div class="slot-time">{{ $dispo->heure_debut }}</div>
                                <div class="slot-date">{{ \Carbon\Carbon::parse($dispo->date)->format('d/m/Y') }}</div>
                            </a>
                        @empty
                            <p class="empty-state">Veuillez sélectionner un médecin pour voir ses disponibilités.</p>
                        @endforelse
                    </div>
                </div>

                {{-- 4. Motif --}}
                <div class="card">
                    <div class="card-title">Motif de consultation</div>
                    <div class="motif-grid">
                        <a href="{{ route('rdv.index', array_merge(request()->query(), ['motif' => 'consultation'])) }}"
                           class="motif-item {{ request('motif') == 'consultation' ? 'selected' : '' }}" style="text-decoration:none; color:inherit;">
                            <span class="motif-icon">🩺</span> Consultation
                        </a>
                        <a href="{{ route('rdv.index', array_merge(request()->query(), ['motif' => 'controle'])) }}"
                           class="motif-item {{ request('motif') == 'controle' ? 'selected' : '' }}" style="text-decoration:none; color:inherit;">
                            <span class="motif-icon">🔄</span> Contrôle
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Colonne DROITE (Récapitulatif) ── --}}
            <div>
                <div class="recap-card">
                    <div class="recap-title">Récapitulatif</div>

                    <div class="recap-row">
                        <div class="recap-icon">👤</div>
                        <div>
                            <div class="recap-label">Médecin</div>
                            <div class="recap-val">{{ $selectedMedecin ? 'Dr. '.$selectedMedecin->user->name : 'Non sélectionné' }}</div>
                        </div>
                    </div>

                    <div class="recap-row">
                        <div class="recap-icon">📅</div>
                        <div>
                            <div class="recap-label">Date & Heure</div>
                            <div class="recap-val">
                                @if($selectedDispo)
                                    {{ \Carbon\Carbon::parse($selectedDispo->date)->translatedFormat('d F Y') }} à {{ $selectedDispo->heure_debut }}
                                @else
                                    Non sélectionnée
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="recap-row">
                        <div class="recap-icon">📝</div>
                        <div>
                            <div class="recap-label">Motif</div>
                            <div class="recap-val">{{ $motif ? ucfirst($motif) : 'Non sélectionné' }}</div>
                        </div>
                    </div>

                    <button class="btn-primary" {{ !$selectedDispo ? 'disabled' : '' }}
                    style="{{ !$selectedDispo ? 'opacity:0.5; cursor:not-allowed' : '' }}">
                        Confirmer le rendez-vous
                    </button>
                </div>
            </div>

        </div>
    </div>







    {{-- Dans votre vue patient::dashboard.rdv --}}

    <form action="{{ route('rdv.store') }}" method="POST">
        @csrf

        {{-- Champs cachés pour transmettre les données au contrôleur Rdv --}}
        <input type="hidden" name="disponibilite_id" value="{{ $selectedDispo->id ?? '' }}">
        <input type="hidden" name="motif" value="{{ request('motif') ?? '' }}">

        <div class="recap-card">
            {{-- ... votre affichage récapitulatif ... --}}

            {{-- IMPORTANT: Type="submit" pour déclencher le formulaire --}}
            <button type="submit" class="btn-primary" id="btnConfirm"
                    {{ !$selectedDispo ? 'disabled' : '' }}
                    style="{{ !$selectedDispo ? 'opacity:0.5; cursor:not-allowed' : '' }}">
                Confirmer le rendez-vous
            </button>
        </div>
    </form>





    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif




    <script>
        // Sélection médecin
        document.querySelectorAll('.medecin-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.medecin-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Sélection spécialité
        document.querySelectorAll('.spec-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.spec-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Sélection motif
        document.querySelectorAll('.motif-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.motif-item').forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Sélection jour calendrier
        document.querySelectorAll('.cal-day.has-slot, .cal-day.today').forEach(day => {
            day.addEventListener('click', function() {
                document.querySelectorAll('.cal-day').forEach(d => d.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Bouton confirmer
        document.getElementById('btnConfirm').addEventListener('click', function() {
            document.getElementById('confirmBanner').style.display = 'flex';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        document.querySelectorAll(".slot-card").forEach(card => {
            card.addEventListener("click", () => {
                card.classList.toggle("active");
            });
        });
    </script>

@endsection
