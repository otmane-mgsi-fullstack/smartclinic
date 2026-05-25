@extends('medecin::dashboard.layout')

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h1 style="color: var(--text); font-size: 24px; font-weight: 700; margin: 0;">Gestion des Patients</h1>
                <p style="color: var(--muted); margin: 4px 0 0;">Visualisez et gérez l'ensemble des patients enregistrés.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('medecin.patients.create') }}" class="btn" style="background: var(--blue); color: #fff; border-radius: 8px; font-weight: 600; padding: 8px 16px;">
                    <i class="bi bi-person-plus-fill"></i> Ajouter un Patient
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
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <form action="{{ route('medecin.patients.index') }}" method="GET" style="display: flex; gap: 8px;">
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Rechercher par Nom, Email, CIN..." style="border-radius: 8px; border: 1px solid var(--border); padding: 8px 12px; font-size: 14px; background: var(--surface2);">
                        <button type="submit" class="btn btn-outline-secondary" style="border-radius: 8px; padding: 8px 16px;">
                            <i class="bi bi-search"></i>
                        </button>
                        @if($search)
                            <a href="{{ route('medecin.patients.index') }}" class="btn btn-link" style="color: var(--muted); display: flex; align-items: center;">Effacer</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border);">
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Patient</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">CIN</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Date de Naissance</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Adresse</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700;">Dossier Médical</th>
                            <th style="padding: 12px 16px; font-size: 11px; text-transform: uppercase; color: var(--hint); font-weight: 700; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            @php
                                $nameParts = explode(' ', $patient->user->name);
                                $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                            @endphp
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 16px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--blue-lt); color: var(--blue); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <span style="display: block; font-weight: 700; color: var(--text);">{{ $patient->user->name }}</span>
                                            <small style="color: var(--muted); font-size: 12px;">{{ $patient->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 16px; vertical-align: middle; font-weight: 600; color: var(--text);">
                                    {{ $patient->cin }}
                                </td>
                                <td style="padding: 16px; vertical-align: middle; color: var(--muted);">
                                    {{ \Carbon\Carbon::parse($patient->date_naissance)->format('d M Y') }}
                                </td>
                                <td style="padding: 16px; vertical-align: middle; color: var(--muted); max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $patient->adresse ?: 'Non renseignée' }}
                                </td>
                                <td style="padding: 16px; vertical-align: middle;">
                                    <a href="{{ route('medecin.documents.index', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-info" style="font-size: 12px; font-weight: 600; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="bi bi-folder2-open"></i> Voir Dossier
                                    </a>
                                </td>
                                <td style="padding: 16px; vertical-align: middle; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('medecin.patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-warning" style="border-radius: 6px;" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('medecin.patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Attention ! Supprimer ce patient détruira son compte et tout son historique. Voulez-vous continuer ?')" style="display: inline;">
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
                                    <i class="bi bi-people" style="font-size: 2rem; color: var(--hint);"></i>
                                    <p style="margin-top: 10px; font-size: 14px;">Aucun patient trouvé.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
@endsection
