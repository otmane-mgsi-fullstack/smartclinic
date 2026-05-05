<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- CSS ici -->
    <link rel="stylesheet" href="{{ asset('css/medecin/index.css') }}">

</head>



<body>



@extends('medecin::dashboard.layout')

@section('content')
    <div class="rdv-container">
        <div class="rdv-header">
            <div>
                <h1 class="title">Gestion des Rendez-vous</h1>
                <p class="subtitle">Consultez et gérez vos consultations à venir</p>
            </div>
            <div class="stats-mini">
                {{-- Badge dynamique pour compter les RDV confirmés --}}
                <span class="badge-pill badge-blue">{{ $rdvs->where('statut', 'confirme')->count() }} Confirmés</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table class="rdv-table">
                <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date & Heure</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($rdvs as $rdv)
                    <tr>
                        <td>
                            <div class="patient-info">
                                <div class="avatar">{{ substr($rdv->patient->user->name, 0, 1) }}</div>
                                <div>
                                    <span class="name">{{ $rdv->patient->user->name }}</span>
                                    <span class="sub">CIN: {{ $rdv->patient->cin }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="date-cell">
                                <strong>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d M Y') }}</strong>
                                <span style="display:block; font-size: 12px; color: var(--muted);">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</span>
                            </div>
                        </td>
                        <td><span class="motif-text">{{ $rdv->motif }}</span></td>
                        <td>
                        <span class="status-pill status-{{ $rdv->statut }}">
                            {{ ucfirst($rdv->statut) }}
                        </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                {{-- On affiche les actions seulement si le RDV n'est pas déjà annulé ou terminé --}}
                                @if($rdv->statut == 'confirme' || $rdv->statut == 'planifie')

                                    {{-- Formulaire pour Terminer --}}
                                    <form action="{{ route('medecin.rdv.status', $rdv->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="statut" value="termine">
                                        <button type="submit" class="btn-icon btn-termine" title="Terminer la consultation">✔️</button>
                                    </form>

                                    {{-- Formulaire pour Annuler --}}
                                    <form action="{{ route('medecin.rdv.status', $rdv->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler ce RDV ?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="statut" value="annule">
                                        <button type="submit" class="btn-icon btn-annule" title="Annuler le rendez-vous">❌</button>
                                    </form>

                                @else
                                    <span style="font-size: 11px; color: var(--hint);">Aucune action</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row" style="text-align: center; padding: 40px; color: var(--muted);">
                            Aucun rendez-vous trouvé.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Intégration de ta charte graphique */
        .rdv-container { padding: 20px; }
        .rdv-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .title { color: var(--text); font-size: 24px; font-weight: 700; margin: 0; }
        .subtitle { color: var(--muted); margin: 4px 0 0; }

        .badge-pill { padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .badge-blue { background: var(--blue-lt); color: var(--blue); }

        .card { background: var(--surface); border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--sh); overflow: hidden; }

        .rdv-table { width: 100%; border-collapse: collapse; text-align: left; }
        .rdv-table th { background: var(--bg); padding: 16px; color: var(--muted); font-size: 13px; font-weight: 600; text-transform: uppercase; }
        .rdv-table td { padding: 16px; border-bottom: 1px solid var(--border); color: var(--text); vertical-align: middle; }

        .patient-info { display: flex; align-items: center; gap: 12px; }
        .avatar { width: 36px; height: 36px; background: var(--blue-lt); color: var(--blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .name { display: block; font-weight: 600; }
        .sub { display: block; font-size: 11px; color: var(--muted); }

        .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-confirme { background: var(--blue-lt); color: var(--blue); }
        .status-planifie { background: var(--amber-lt); color: var(--amber); }
        .status-annule { background: var(--red-lt); color: var(--red); }
        .status-termine { background: var(--green-lt); color: var(--green); }

        .action-btns { display: flex; gap: 8px; }
        .btn-icon {
            border: 1px solid var(--border);
            background: var(--surface);
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover { transform: translateY(-2px); box-shadow: var(--sh); }
        .btn-termine:hover { border-color: var(--green); background: var(--green-lt); }
        .btn-annule:hover { border-color: var(--red); background: var(--red-lt); }

        .alert { padding: 12px; border-radius: 8px; margin-bottom: 16px; background: var(--green-lt); color: var(--green); border: 1px solid var(--green); }

        .motif-text { font-size: 13px; color: var(--muted); }
    </style>
@endsection




</body>
</html>

