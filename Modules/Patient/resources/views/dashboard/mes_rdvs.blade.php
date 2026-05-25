@extends('patient::dashboard.layout')

@section('content')
    <div class="card" style="background: var(--surface); border: .5px solid var(--border); border-radius: 12px; padding: 24px;">
        <div class="card-head" style="margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
            <div>
                <h2 style="font-size: 18px; font-weight: 500; color: var(--text);">Mes Rendez-vous</h2>
                <p style="font-size: 13px; color: var(--muted); margin-top: 2px;">Historique complet de vos consultations cliniques.</p>
            </div>
            <a href="{{ route('rdv.index') }}" class="btn-rdv" style="text-decoration: none; padding: 8px 16px;">
                <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: #fff; margin-right: 6px;"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                Prendre un nouveau RDV
            </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($rdvs as $rdv)
                @php
                    $dt = \Carbon\Carbon::parse($rdv->date_heure);
                    $day = $dt->format('d');
                    $month = strtoupper($dt->translatedFormat('F'));
                    $year = $dt->format('Y');
                    
                    // Style de badge
                    $badgeClass = 'badge-blue';
                    if ($rdv->statut === 'termine') $badgeClass = 'badge-green';
                    if ($rdv->statut === 'annule') $badgeClass = 'badge-red';
                    if ($rdv->statut === 'planifie') $badgeClass = 'badge-amber';
                @endphp
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border: 1px solid var(--border); border-radius: 10px; background: var(--bg);">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 10px; text-align: center; min-width: 70px;">
                            <div style="font-size: 20px; font-weight: bold; color: var(--blue);">{{ $day }}</div>
                            <div style="font-size: 10px; font-weight: 600; color: var(--muted); text-transform: uppercase;">{{ substr($month, 0, 4) }}</div>
                        </div>
                        <div>
                            <div style="font-size: 15px; font-weight: 600; color: var(--text);">Dr. {{ $rdv->medecin->user->name }}</div>
                            <div style="font-size: 13px; color: var(--muted); margin-top: 2px;">{{ $rdv->medecin->specialite }}</div>
                            <div style="font-size: 12px; color: var(--hint); margin-top: 4px; display: flex; align-items: center; gap: 6px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                                {{ $dt->format('H:i') }} &bull; Motif : {{ $rdv->motif ?: 'Général' }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="badge {{ $badgeClass }}" style="font-size: 12px; padding: 4px 12px;">{{ ucfirst($rdv->statut) }}</span>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 60px; color: var(--muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 48px; height: 48px; color: var(--hint); margin-bottom: 12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                    <p style="font-size: 14px;">Vous n'avez pas de rendez-vous programmé.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
