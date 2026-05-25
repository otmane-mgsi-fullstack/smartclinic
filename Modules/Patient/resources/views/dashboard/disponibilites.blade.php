@extends('patient::dashboard.layout')

@section('content')
    <div class="card" style="background: var(--surface); border: .5px solid var(--border); border-radius: 12px; padding: 24px;">
        <div class="card-head" style="margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
            <div>
                <h2 style="font-size: 18px; font-weight: 500; color: var(--text);">Disponibilités de la Clinique</h2>
                <p style="font-size: 13px; color: var(--muted); margin-top: 2px;">Consultez les créneaux de consultation disponibles et planifiez un rendez-vous.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
            @forelse($disponibilites as $dispo)
                @php
                    $dt = \Carbon\Carbon::parse($dispo->date);
                    $day = $dt->translatedFormat('d F Y');
                    $nameParts = explode(' ', $dispo->medecin->user->name);
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                @endphp
                <div style="background: var(--bg); border: 1px solid var(--border); border-radius: 12px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; gap: 14px; position: relative; transition: border-color .15s;">
                    <!-- Top Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--blue-lt); color: var(--blue); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                                {{ $initials }}
                            </div>
                            <div>
                                <h4 style="font-size: 14px; font-weight: 600; color: var(--text); margin: 0;">Dr. {{ $dispo->medecin->user->name }}</h4>
                                <span style="font-size: 11px; color: var(--muted);">{{ $dispo->medecin->specialite }}</span>
                            </div>
                        </div>
                        <div style="border-top: .5px solid var(--border); padding-top: 10px;">
                            <div style="font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 6px;">
                                <svg width="12" height="12" fill="currentColor" style="color:var(--blue);"><path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V10h14v10z"/></svg>
                                {{ $day }}
                            </div>
                            <div style="font-size: 15px; font-weight: bold; color: var(--text); margin-top: 4px; display: flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" fill="currentColor" style="color:var(--blue);"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                                {{ \Carbon\Carbon::parse($dispo->heure_debut)->format('H:i') }} &ndash; {{ \Carbon\Carbon::parse($dispo->heure_fin)->format('H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Book Button -->
                    <a href="{{ route('rdv.index', ['medecin_id' => $dispo->medecin_id, 'dispo' => $dispo->id]) }}" style="text-decoration: none;">
                        <button style="width: 100%; border: none; background: var(--blue); color: #fff; border-radius: 8px; padding: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: opacity .15s;">
                            Réserver ce créneau
                        </button>
                    </a>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 48px; height: 48px; color: var(--hint); margin-bottom: 12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p style="font-size: 14px;">Aucun créneau de consultation libre n'est disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
