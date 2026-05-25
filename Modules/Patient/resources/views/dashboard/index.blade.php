@extends('patient::dashboard.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/patient/index.css') }}">

    <div class="grid2">
        <!-- MES RDV -->
        <div class="card">
            <div class="card-head">
                <span class="card-title">Mes rendez-vous récents</span>
                <a href="{{ route('patient.mes_rdvs') }}" class="card-link" style="text-decoration: none;">Voir tout →</a>
            </div>

            @forelse($rdvs as $rdv)
                @php
                    $dt = \Carbon\Carbon::parse($rdv->date_heure);
                    $day = $dt->format('d');
                    $month = strtoupper($dt->translatedFormat('M'));
                    
                    // Style de badge
                    $badgeClass = 'badge-blue';
                    if ($rdv->statut === 'termine') $badgeClass = 'badge-green';
                    if ($rdv->statut === 'annule') $badgeClass = 'badge-red';
                    if ($rdv->statut === 'planifie') $badgeClass = 'badge-amber';
                @endphp
                <div class="rdv-item">
                    <div class="rdv-date">
                        <div class="day">{{ $day }}</div>
                        <div class="month">{{ $month }}</div>
                    </div>
                    <div class="rdv-info">
                        <div class="rdv-doctor">Dr. {{ $rdv->medecin->user->name }}</div>
                        <div class="rdv-spec">{{ $rdv->medecin->specialite }}</div>
                        <div class="rdv-time">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="color:var(--hint)"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                            {{ $dt->format('H:i') }}
                        </div>
                    </div>
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($rdv->statut) }}</span>
                </div>
            @empty
                <div style="text-align: center; padding: 30px; color: var(--muted); font-size: 13px;">
                    Aucun rendez-vous enregistré. <br>
                    <a href="{{ route('rdv.index') }}" style="color: var(--blue); font-weight: bold; text-decoration: none; display: inline-block; margin-top: 10px;">Prendre un rendez-vous maintenant</a>
                </div>
            @endforelse
        </div>

        <!-- MES DOCUMENTS -->
        <div class="card">
            <div class="card-head">
                <span class="card-title">Mes documents récents</span>
                <a href="{{ route('patient.documents') }}" class="card-link" style="text-decoration: none;">Voir tout →</a>
            </div>

            @forelse($documents as $doc)
                <div class="doc-item">
                    <div class="doc-icon {{ $doc->type_document === 'ordonnance' ? 'doc-word' : 'doc-pdf' }}">
                        {{ strtoupper(substr($doc->type_document, 0, 3)) }}
                    </div>
                    <div class="doc-info">
                        <div class="doc-name">{{ $doc->nom_fichier }}</div>
                        <div class="doc-date">{{ $doc->date_upload->translatedFormat('j M Y') }} &bull; {{ ucfirst($doc->type_document) }}</div>
                    </div>
                    <a href="{{ route('patient.documents.download', $doc->id) }}" class="doc-dl" style="text-decoration: none;">
                        ↓ Télécharger
                    </a>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: var(--muted); font-size: 13px;">
                    Aucun document disponible dans votre dossier.
                </div>
            @endforelse
        </div>
    </div>

    <!-- MESSAGERIE BANNER (Accès rapide) -->
    <div class="msg-coming">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <h3>Messagerie instantanée</h3>
        <p>Discutez en temps réel avec vos professionnels de santé pour un suivi optimal.</p>
        <a href="{{ route('patient.messages') }}" class="btn-notify" style="text-decoration: none; display: inline-block;">Ouvrir la messagerie →</a>
    </div>
@endsection
