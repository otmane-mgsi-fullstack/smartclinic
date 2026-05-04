@extends('medecin::dashboard.layout')

@section('title', 'Disponibilités')


    <style>
        /* ── Variables ── */
        :root {
            --bg:        #f4f6f9;
            --surface:   #ffffff;
            --surface2:  #eef1f6;
            --border:    #e2e6ed;
            --text:      #0f172a;
            --muted:     #64748b;
            --hint:      #94a3b8;
            --blue:      #1d4ed8;
            --blue-lt:   #eff4ff;
            --blue-md:   #93c5fd;
            --teal:      #0d9488;
            --teal-lt:   #f0fdfa;
            --red:       #dc2626;
            --red-lt:    #fef2f2;
            --amber:     #b45309;
            --amber-lt:  #fffbeb;
            --green:     #059669;
            --green-lt:  #ecfdf5;
            --sh:        0 1px 3px rgba(15,23,42,0.06), 0 4px 12px rgba(15,23,42,0.04);
            --sh-md:     0 4px 20px rgba(15,23,42,0.10);
        }

        /* ── Page wrapper ── */
        .dispo-page {
            padding: 2rem 2.5rem;
            background: var(--bg);
            min-height: 100vh;
            font-family: 'Figtree', 'Segoe UI', sans-serif;
            color: var(--text);
        }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: .6rem;
            margin: 0;
        }

        .page-header h1 .icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--blue-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .toolbar .date-picker-wrap {
            position: relative;
        }

        .toolbar .date-picker-wrap input[type="date"] {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .5rem 1rem .5rem 2.6rem;
            font-size: .9rem;
            color: var(--text);
            background: var(--surface);
            box-shadow: var(--sh);
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .toolbar .date-picker-wrap input[type="date"]:focus {
            border-color: var(--blue-md);
        }

        .toolbar .date-picker-wrap .cal-icon {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .95rem;
            pointer-events: none;
        }

        /* ── Stats row ── */
      /*  .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        } */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;

            background:
                linear-gradient(rgba(255,255,255,0.6), rgba(255,255,255,0.6)),
                url('https://images.unsplash.com/photo-1580281657527-47b7f9d1d0b5?auto=format&fit=crop&w=1600&q=80');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            padding: 1.5rem;
            border-radius: 16px;
        }
        .stat-card {
            /* Fond plus cristallin */
            background: #ffffff;
            border: 2px solid #f1f5f9; /* Bordure plus épaisse mais plus claire */
            border-radius: 20px; /* Coins beaucoup plus arrondis */

            padding: 1.25rem;

            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.5rem;

            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;

            box-shadow:
                0 1px 2px rgba(0, 0, 0, 0.05),
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        /* Effet d'élévation au survol */
        .stat-card:hover {
            transform: translateY(-4px);
            border-color: #3b82f6; /* Accentuation bleue au survol */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        /* Petit indicateur de disponibilité (à ajouter dans le HTML) */
        .stat-card::before {
            content: "";
            position: absolute;
            top: 12px;
            right: 12px;
            width: 8px;
            height: 8px;
            background: #10b981; /* Vert dispo */
            border-radius: 50%;
        }



        .stat-card .stat-label {
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .stat-card.green  { border-left: 4px solid var(--green);  }
        .stat-card.green  .stat-value { color: var(--green); }
        .stat-card.red    { border-left: 4px solid var(--red);    }
        .stat-card.red    .stat-value { color: var(--red); }
        .stat-card.amber  { border-left: 4px solid var(--amber);  }
        .stat-card.amber  .stat-value { color: var(--amber); }
        .stat-card.blue   { border-left: 4px solid var(--blue);   }
        .stat-card.blue   .stat-value { color: var(--blue); }

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

        /* badge statut propre */
        .badge-status {
            font-size: .72rem;
            font-weight: 600;
            padding: .25rem .6rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        /* statuts */
        .badge-status.disponible {
            background: #ecfdf5;
            color: #059669;
        }

        .badge-status.reserve {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-status.indisponible {
            background: #f3f4f6;
            color: #6b7280;
        }

        /* actions (edit/delete) */
        .slot-actions {
            display: flex;
            justify-content: flex-end;
            gap: .4rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-icon:hover {
            background: #f3f4f6;
            border-color: #cbd5e1;
        }

        .btn-icon.danger:hover {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }



        /* ── Empty state ── */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3.5rem 1rem;
            color: var(--hint);
        }

        .empty-state .empty-icon {
            font-size: 2.5rem;
            margin-bottom: .75rem;
            display: block;
        }

        .empty-state p {
            font-size: .9rem;
            margin: 0;
        }

        /* ── Primary button ── */
        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: var(--blue);
            color: #fff;
            font-size: .875rem;
            font-weight: 600;
            padding: .55rem 1.2rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(29,78,216,.25);
            transition: background .2s, box-shadow .2s;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            background: #1a44c2;
            box-shadow: 0 4px 14px rgba(29,78,216,.35);
            color: #fff;
        }

        /* ── Modal ── */
        .modal-content {
            border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: var(--sh-md);
        }

        .modal-header {
            border-bottom: 1.5px solid var(--border);
            padding: 1.1rem 1.5rem;
        }

        .modal-header .modal-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .modal-footer {
            border-top: 1.5px solid var(--border);
            padding: .9rem 1.5rem;
            gap: .5rem;
        }

        .modal-body {
            padding: 1.4rem 1.5rem;
        }

        /* ── Form fields ── */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .form-control-custom {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .55rem .9rem;
            font-size: .9rem;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }

        .form-control-custom:focus {
            border-color: var(--blue-md);
            box-shadow: 0 0 0 3px rgba(147,197,253,.25);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
        }

        /* ── Status selector ── */
        .status-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .5rem;
            margin-top: .4rem;
        }

        .status-option {
            display: none;
        }

        .status-option + label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .3rem;
            padding: .65rem .4rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            cursor: pointer;
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            transition: all .2s;
            text-align: center;
        }

        .status-option + label .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-option[value="disponible"] + label .dot   { background: var(--green); }
        .status-option[value="reserve"] + label .dot      { background: var(--red); }
        .status-option[value="indisponible"] + label .dot { background: var(--hint); }

        .status-option[value="disponible"]:checked + label  { background: var(--green-lt);  border-color: var(--green);  color: var(--green); }
        .status-option[value="reserve"]:checked + label     { background: var(--red-lt);    border-color: var(--red);    color: var(--red); }
        .status-option[value="indisponible"]:checked + label{ background: var(--surface2);  border-color: var(--hint);   color: var(--muted); }

        .btn-cancel {
            background: var(--surface2);
            color: var(--muted);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .5rem 1rem;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-cancel:hover { background: var(--border); }
    </style>

@section('content')
    <div class="dispo-page">

        {{-- ── Header ── --}}
        <div class="page-header">
            <h1>
                <span class="icon-wrap">📅</span>
                Gestion des disponibilités
            </h1>

            <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalAdd">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Ajouter un créneau
            </button>
        </div>

        {{-- ── Stats ── --}}

            <div class="stats-row bg-white p-3 rounded-4 shadow-sm border">
            <div class="stat-card green">
                <span class="stat-label">Disponibles</span>
                <span class="stat-value" id="count-disponible">
                    {{ $disponibilites->where('statut', 'disponible')->count() }}
                </span>
            </div>

            <div class="stat-card red">
                <span class="stat-label">Réservés</span>
                <span class="stat-value" id="count-reserve">
                    {{ $disponibilites->where('statut', 'reserve')->count() }}
                </span>
            </div>

            <div class="stat-card amber">
                <span class="stat-label">Indisponibles</span>
                <span class="stat-value" id="count-indisponible">
                    {{ $disponibilites->where('statut', 'indisponible')->count() }}

                </span>
            </div>
            <div class="stat-card blue">
                <span class="stat-label">Total créneaux</span>
                <span class="stat-value" id="count-total">
                    {{ $disponibilites->count() }}
                </span>
            </div>



        </div>







        <div class="toolbar">
            <form method="GET" id="filter-form">
                <div class="row g-2 align-items-center">

                    {{-- Date --}}
                    <div class="col-md-6">
                        <input
                            type="date"
                            name="date"
                            class="form-control"
                            value="{{ request('date') }}"
                            onchange="this.form.submit();"
                        >
                    </div>

                    {{-- Statut --}}
                    <div class="col-md-6">
                        <select name="statut" class="form-select" onchange="this.form.submit();">
                            <option value="">Tous les statuts</option>
                            <option value="disponible" {{ request('statut') == 'disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>
                            <option value="reserve" {{ request('statut') == 'reserve' ? 'selected' : '' }}>
                                Réservé
                            </option>
                            <option value="indisponible" {{ request('statut') == 'indisponible' ? 'selected' : '' }}>
                                Indisponible
                            </option>
                        </select>
                    </div>

                </div>
            </form>
        </div>







        <div class="slots-grid" id="slots-container">

            @forelse($disponibilites as $dispo)

                <div class="slot-card">

                    <div class="slot-top">
                        <div>
                            <div class="slot-time">
                                {{ $dispo->heure_debut }} – {{ $dispo->heure_fin }}
                            </div>
                            <div class="slot-date">
                                {{ \Carbon\Carbon::parse($dispo->date)->format('d/m/Y') }}
                            </div>
                        </div>

                        <span class="badge-status {{ $dispo->statut }}">
                    {{ ucfirst($dispo->statut) }}
                </span>
                    </div>



                </div>

            @empty

                <div class="empty-state">
                    <span class="empty-icon">🗓</span>
                    <p>
                        Aucun créneau pour le moment.<br>
                        Cliquez sur <strong>Ajouter un créneau</strong> pour commencer.
                    </p>
                </div>

            @endforelse

        </div>


        <div class="d-flex justify-content-center mt-4">
            {{ $disponibilites->links() }}
        </div>










    </div>

    {{-- ── Modal Add / Edit ── --}}
    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span id="modal-title-text">Ajouter un créneau</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                <form action="{{Route('medecin.dispo.store')}}" method="POST">
                    @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" id="f-date" class="form-control-custom" name="date">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Heure début</label>
                            <input type="time" id="f-start" class="form-control-custom" name="heure_debut">
                        </div>

                        @error('heure_debut')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror



                        <div class="form-group">
                            <label>Heure fin</label>
                            <input type="time" id="f-end" class="form-control-custom" name="heure_fin">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Statut</label>
                        <div class="status-selector">
                            <input type="radio" name="statut" id="s-dispo" value="disponible" checked>
                            <label for="s-dispo">
                                <span class="dot"></span>
                                Disponible
                            </label>

                            <input type="radio" name="statut" id="s-reserve" class="status-option" value="reserve">
                            <label for="s-reserve">
                                <span class="dot"></span>
                                Réservé
                            </label>

                            <input type="radio" name="statut" id="s-indispo" class="status-option" value="indisponible">
                            <label for="s-indispo">
                                <span class="dot"></span>
                                Indisponible
                            </label>
                        </div>
                    </div>

                </div>


                <div class="modal-footer justify-content-end">
                    <button class="btn-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button class="btn-primary-custom">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Enregistrer
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection



