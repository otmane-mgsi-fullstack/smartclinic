@extends('patient::dashboard.layout')

@section('content')
    <div class="card" style="background: var(--surface); border: .5px solid var(--border); border-radius: 12px; padding: 24px;">
        <div class="card-head" style="margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
            <div>
                <h2 style="font-size: 18px; font-weight: 500; color: var(--text);">Mon Dossier Médical (Documents)</h2>
                <p style="font-size: 13px; color: var(--muted); margin-top: 2px;">Consultez et téléchargez vos ordonnances, analyses et comptes-rendus.</p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($documents as $doc)
                @php
                    $isOrdonnance = $doc->type_document === 'ordonnance';
                    $isAnalyse = $doc->type_document === 'analyse';
                    $isRadio = $doc->type_document === 'radio';
                    
                    // Style de badge
                    $iconClass = 'doc-pdf';
                    if ($isOrdonnance) $iconClass = 'doc-word';
                @endphp
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid var(--border); border-radius: 10px; background: var(--bg);">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="doc-icon {{ $iconClass }}" style="width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px;">
                            {{ strtoupper(substr($doc->type_document, 0, 3)) }}
                        </div>
                        <div>
                            <div style="font-size: 14px; font-weight: 600; color: var(--text);">{{ $doc->nom_fichier }}</div>
                            <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">
                                Type : <strong>{{ ucfirst($doc->type_document) }}</strong> &bull; 
                                Importé le : {{ $doc->date_upload->translatedFormat('d M Y à H:i') }} &bull;
                                Taille : {{ $doc->taille_fichier ? round($doc->taille_fichier / 1024, 1) . ' KB' : 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('patient.documents.download', $doc->id) }}" class="doc-dl" style="text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-size: 13px; font-weight: 600; background: var(--surface); padding: 6px 12px; border: 1px solid var(--border); border-radius: 6px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Télécharger
                        </a>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 60px; color: var(--muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 48px; height: 48px; color: var(--hint); margin-bottom: 12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <p style="font-size: 14px;">Aucun document disponible dans votre dossier médical pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
