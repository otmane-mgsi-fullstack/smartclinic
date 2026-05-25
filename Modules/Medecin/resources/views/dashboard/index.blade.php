@extends('medecin::dashboard.layout')

@section('content')
    <!-- CSS direct pour personnalisations supplémentaires -->
    <link rel="stylesheet" href="{{ asset('css/medecin/index.css') }}">
    <style>
        .status-pill { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
        .status-ordonnance { background: var(--blue-lt); color: var(--blue); }
        .status-analyse { background: var(--teal-lt); color: var(--teal); }
        .status-radio { background: var(--amber-lt); color: var(--amber); }
        .status-autre { background: var(--green-lt); color: var(--green); }
        
        .timeline-container { display: flex; flex-direction: column; gap: 12px; }
        .timeline-item { display: flex; gap: 15px; border-left: 2px solid var(--border); padding-left: 20px; position: relative; margin-left: 10px; }
        .timeline-item::before { content: ''; position: absolute; left: -6px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: var(--blue); }
        .timeline-item.done::before { background: var(--green); }
        .timeline-item.cancelled::before { background: var(--red); }
        .timeline-time { font-weight: 700; color: var(--text); min-width: 50px; }
        .timeline-content { flex: 1; background: var(--surface2); padding: 10px 14px; border-radius: 8px; border-left: 3px solid var(--blue); }
        .timeline-content.done { border-left-color: var(--green); }
        .timeline-content.cancelled { border-left-color: var(--red); }
    </style>

    <!-- STAT BAND -->
    <div class="stat-band">
        <div class="stat-card">
            <div class="stat-ico blue"><i class="bi bi-calendar-check"></i></div>
            <div>
                <div class="stat-label">Consultations aujourd'hui</div>
                <div class="stat-val">{{ $nbRdvAujourdhui }}</div>
                <div class="stat-note">Prévues ce jour</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico teal"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-label">Patients vus ce mois</div>
                <div class="stat-val">{{ $nbPatientsCeMois }}</div>
                <div class="stat-note">Consultations uniques</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico amber"><i class="bi bi-folder-fill"></i></div>
            <div>
                <div class="stat-label">Documents (Dossiers)</div>
                <div class="stat-val">{{ $nbTotalDocuments }}</div>
                <div class="stat-note">Fichiers uploadés</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico green"><i class="bi bi-clipboard2-pulse"></i></div>
            <div>
                <div class="stat-label">Ordonnances émises</div>
                <div class="stat-val">{{ $nbOrdonnances }}</div>
                <div class="stat-note">Depuis la clinique</div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID : Planning + Patients -->
    <div class="main-grid">

        <!-- PLANNING -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Mon planning du jour</div>
                    <div class="card-sub">{{ $dateAffichage }} · {{ $rdvsAujourdhui->count() }} consultation(s)</div>
                </div>
                <a href="{{ route('medecin.patients.create') }}" class="pill-btn"><i class="bi bi-plus"></i> Ajouter Patient</a>
            </div>

            <div class="timeline-container">
                @forelse($rdvsAujourdhui as $rdv)
                    @php
                        $isDone = $rdv->statut === 'termine';
                        $isCancelled = $rdv->statut === 'annule';
                        $class = $isDone ? 'done' : ($isCancelled ? 'cancelled' : '');
                    @endphp
                    <div class="timeline-item {{ $class }}">
                        <div class="timeline-time">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</div>
                        <div class="timeline-content {{ $class }}">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <strong>{{ $rdv->patient->user->name }}</strong>
                                <span class="badge-pill" style="font-size: 10px; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid var(--border);">
                                    {{ ucfirst($rdv->statut) }}
                                </span>
                            </div>
                            <div style="font-size: 12px; color: var(--muted); margin-top: 3px;">
                                Motif : {{ $rdv->motif ?: 'Consultation générale' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: var(--muted);">
                        <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                        <p style="margin-top: 10px;">Aucun rendez-vous planifié pour aujourd'hui.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- PATIENTS DU JOUR (Raccourcis vers dossiers) -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Patients d'aujourd'hui</div>
                    <div class="card-sub">Accès rapide aux dossiers</div>
                </div>
            </div>
            <div class="patient-list">
                @forelse($rdvsAujourdhui as $rdv)
                    @php
                        $nameParts = explode(' ', $rdv->patient->user->name);
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                    @endphp
                    <a href="{{ route('medecin.documents.index', ['patient_id' => $rdv->patient->id]) }}" class="patient-row" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                        <div class="pt-avatar" style="background:#dbeafe; color:var(--blue);">{{ $initials }}</div>
                        <div>
                            <div class="pt-name">{{ $rdv->patient->user->name }}</div>
                            <div class="pt-info">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }} · {{ substr($rdv->motif, 0, 20) }}...</div>
                        </div>
                        <i class="bi bi-folder2-open" style="margin-left: auto; color: var(--muted);"></i>
                    </a>
                @empty
                    <div style="text-align: center; padding: 20px; color: var(--muted); font-size: 12px;">
                        Aucun patient aujourd'hui.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- BOTTOM GRID : Dossiers récents -->
    <div class="bottom-grid" style="grid-template-columns: 1fr;">
        <!-- DOSSIERS RECENTS -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Documents médicaux récents</div>
                    <div class="card-sub">Derniers fichiers uploadés par les patients</div>
                </div>
                <a href="{{ route('medecin.documents.index') }}" class="pill-btn">Voir tout <i class="bi bi-arrow-right"></i></a>
            </div>
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 12px; border-bottom: 2px solid var(--border);">Patient</th>
                        <th style="padding: 12px; border-bottom: 2px solid var(--border);">Type</th>
                        <th style="padding: 12px; border-bottom: 2px solid var(--border);">Document</th>
                        <th style="padding: 12px; border-bottom: 2px solid var(--border);">Taille</th>
                        <th style="padding: 12px; border-bottom: 2px solid var(--border);">Date d'ajout</th>
                        <th style="padding: 12px; border-bottom: 2px solid var(--border);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentsRecents as $doc)
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid var(--border); font-weight:700;">
                                {{ $doc->patient->user->name }} <br>
                                <small style="color:var(--muted); font-weight:normal;">CIN: {{ $doc->patient->cin }}</small>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--border);">
                                <span class="status-pill status-{{ $doc->type_document }}">
                                    {{ ucfirst($doc->type_document) }}
                                </span>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--border);">
                                <i class="bi bi-file-earmark-arrow-down" style="color:var(--blue); font-size:16px;"></i>
                                <span style="font-weight: 500;">{{ $doc->nom_fichier }}</span>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--border); color:var(--muted);">
                                {{ $doc->taille_fichier ? round($doc->taille_fichier / 1024, 1) . ' KB' : 'N/A' }}
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--border); color:var(--muted); font-size:12px;">
                                {{ $doc->date_upload->format('d M Y H:i') }}
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--border);">
                                <div style="display:flex; gap:6px;">
                                    <a href="{{ route('medecin.documents.download', $doc->id) }}" class="btn btn-sm btn-outline-primary" style="padding: 2px 6px; font-size: 12px;" title="Télécharger">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('medecin.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer ce document ?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 2px 6px; font-size: 12px;" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--muted);">
                                Aucun document récent.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
