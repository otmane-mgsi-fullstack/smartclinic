@extends('medecin::dashboard.layout')

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h1 style="color: var(--text); font-size: 24px; font-weight: 700; margin: 0;">Dossiers Médicaux (Documents)</h1>
                <p style="color: var(--muted); margin: 4px 0 0;">Consultez et gérez les documents importés par vos patients.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('medecin.documents.create', ['patient_id' => $selectedPatientId]) }}" class="btn" style="background: var(--blue); color: #fff; border-radius: 8px; font-weight: 600; padding: 8px 16px;">
                    <i class="bi bi-file-earmark-plus"></i> Ajouter un Document
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: var(--green-lt); color: var(--green); border-color: var(--green); border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card" style="background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 20px 22px; box-shadow: var(--sh); overflow: hidden;">
            
            <!-- Barre de filtres -->
            <form action="{{ route('medecin.documents.index') }}" method="GET" class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text); font-size: 13px;">Filtrer par Patient (Dossier)</label>
                    <select name="patient_id" class="form-select" style="border-radius: 8px;" onchange="this.form.submit()">
                        <option value="">-- Tous les dossiers patients --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $selectedPatientId == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} (CIN: {{ $patient->cin }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text); font-size: 13px;">Rechercher un fichier</label>
                    <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Nom du document..." style="border-radius: 8px;">
                </div>

                <div class="col-md-4" style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-outline-primary" style="border-radius: 8px; flex: 1; font-weight: 600; padding: 8px;">
                        <i class="bi bi-funnel"></i> Filtrer / Rechercher
                    </button>
                    @if($selectedPatientId || $search)
                        <a href="{{ route('medecin.documents.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;" title="Réinitialiser">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>

            @if($selectedPatientId)
                @php
                    $activePatient = $patients->firstWhere('id', $selectedPatientId);
                @endphp
                @if($activePatient)
                    <div style="background: var(--blue-lt); border: 1px solid var(--blue-md); border-radius: 10px; padding: 15px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h4 style="margin: 0; color: var(--blue); font-size: 16px; font-weight: 700;">Dossier Médical de : {{ $activePatient->user->name }}</h4>
                            <p style="margin: 3px 0 0; color: var(--muted); font-size: 12.5px;">
                                CIN: <strong>{{ $activePatient->cin }}</strong> &bull; 
                                Date de naissance: <strong>{{ \Carbon\Carbon::parse($activePatient->date_naissance)->format('d/m/Y') }}</strong> &bull; 
                                Adresse: <strong>{{ $activePatient->adresse ?: 'N/A' }}</strong>
                            </p>
                        </div>
                        <div style="font-size: 12px; font-weight: bold; background: #fff; padding: 4px 10px; border-radius: 6px; border: 1px solid var(--blue-md);">
                            {{ $documents->total() }} document(s) trouvé(s)
                        </div>
                    </div>
                @endif
            @endif

            <!-- Tableau des Documents -->
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border); background: var(--bg);">
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Patient</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Type</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Nom du document</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Taille</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Date d'ajout</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 16px; vertical-align: middle;">
                                    <span style="font-weight: 700; color: var(--text);">{{ $doc->patient->user->name }}</span><br>
                                    <small style="color: var(--muted);">CIN: {{ $doc->patient->cin }}</small>
                                </td>
                                <td style="padding: 16px; vertical-align: middle;">
                                    <span class="status-pill status-{{ $doc->type_document }}">
                                        {{ ucfirst($doc->type_document) }}
                                    </span>
                                </td>
                                <td style="padding: 16px; vertical-align: middle; font-weight: 500;">
                                    <a href="{{ route('medecin.documents.download', $doc->id) }}" style="text-decoration: none; color: var(--blue); display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-file-earmark-pdf-fill" style="font-size: 18px;"></i>
                                        {{ $doc->nom_fichier }}
                                    </a>
                                </td>
                                <td style="padding: 16px; vertical-align: middle; color: var(--muted);">
                                    {{ $doc->taille_fichier ? round($doc->taille_fichier / 1024, 1) . ' KB' : 'N/A' }}
                                </td>
                                <td style="padding: 16px; vertical-align: middle; color: var(--muted); font-size: 12px;">
                                    {{ $doc->date_upload->format('d M Y H:i') }}
                                </td>
                                <td style="padding: 16px; vertical-align: middle; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('medecin.documents.download', $doc->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;" title="Télécharger">
                                            <i class="bi bi-download"></i> Télécharger
                                        </a>
                                        <form action="{{ route('medecin.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment retirer ce document du dossier médical ?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: var(--muted);">
                                    <i class="bi bi-folder-x" style="font-size: 2.5rem; color: var(--hint);"></i>
                                    <p style="margin-top: 10px; font-size: 14px;">Aucun document ou fichier dans ce dossier.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    <style>
        .status-pill { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
        .status-ordonnance { background: var(--blue-lt); color: var(--blue); }
        .status-analyse { background: var(--teal-lt); color: var(--teal); }
        .status-radio { background: var(--amber-lt); color: var(--amber); }
        .status-autre { background: var(--green-lt); color: var(--green); }
    </style>
@endsection
