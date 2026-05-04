
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- CSS ici -->
    <link rel="stylesheet" href="{{ asset('css/patient/index.css') }}">

</head>



<body>
@extends('patient::dashboard.layout')


@section('content')



    <div class="grid2">
        <div class="card">
            <div class="card-head">
                <span class="card-title">Mes rendez-vous</span>
                <span class="card-link">Voir tout →</span>
            </div>

            <div class="rdv-item">
                <div class="rdv-date">
                    <div class="day">08</div>
                    <div class="month">MAI</div>
                </div>
                <div class="rdv-info">
                    <div class="rdv-doctor">Dr. Youssef Alami</div>
                    <div class="rdv-spec">Cardiologue — Clinique Ibn Sina</div>
                    <div class="rdv-time">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="color:var(--hint)"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                        10h30
                    </div>
                </div>
                <span class="badge badge-blue">Confirmé</span>
            </div>

            <div class="rdv-item">
                <div class="rdv-date">
                    <div class="day">21</div>
                    <div class="month">MAI</div>
                </div>
                <div class="rdv-info">
                    <div class="rdv-doctor">Dr. Fatima Benali</div>
                    <div class="rdv-spec">Généraliste — Cabinet Oud Melloul</div>
                    <div class="rdv-time">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="color:var(--hint)"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                        09h00
                    </div>
                </div>
                <span class="badge badge-amber">En attente</span>
            </div>

            <div class="rdv-item">
                <div class="rdv-date" style="background:var(--bg)">
                    <div class="day" style="color:var(--muted)">12</div>
                    <div class="month" style="color:var(--hint)">AVR</div>
                </div>
                <div class="rdv-info">
                    <div class="rdv-doctor">Dr. Khalid Mourad</div>
                    <div class="rdv-spec">Dermatologue — Polyclinique</div>
                    <div class="rdv-time">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="color:var(--hint)"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                        14h15
                    </div>
                </div>
                <span class="badge badge-green">Terminé</span>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span class="card-title">Mes documents</span>
                <span class="card-link">Voir tout →</span>
            </div>

            <div class="doc-item">
                <div class="doc-icon doc-pdf">PDF</div>
                <div class="doc-info">
                    <div class="doc-name">Ordonnance — Dr. Alami</div>
                    <div class="doc-date">2 mai 2026</div>
                </div>
                <span class="doc-dl">↓ Télécharger</span>
            </div>

            <div class="doc-item">
                <div class="doc-icon doc-word">DOC</div>
                <div class="doc-info">
                    <div class="doc-name">Rapport cardiologie</div>
                    <div class="doc-date">28 avr. 2026</div>
                </div>
                <span class="doc-dl">↓ Télécharger</span>
            </div>

            <div class="doc-item">
                <div class="doc-icon doc-pdf">PDF</div>
                <div class="doc-info">
                    <div class="doc-name">Résultats analyses sanguines</div>
                    <div class="doc-date">15 avr. 2026</div>
                </div>
                <span class="doc-dl">↓ Télécharger</span>
            </div>

            <div class="doc-item">
                <div class="doc-icon doc-pdf">PDF</div>
                <div class="doc-info">
                    <div class="doc-name">Ordonnance — Dr. Benali</div>
                    <div class="doc-date">12 avr. 2026</div>
                </div>
                <span class="doc-dl">↓ Télécharger</span>
            </div>

            <div class="doc-item">
                <div class="doc-icon doc-word">DOC</div>
                <div class="doc-info">
                    <div class="doc-name">Compte-rendu dermatologue</div>
                    <div class="doc-date">12 avr. 2026</div>
                </div>
                <span class="doc-dl">↓ Télécharger</span>
            </div>
        </div>
    </div>

    <div class="msg-coming">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <h3>Messagerie avec le médecin</h3>
        <p>Bientôt disponible — posez vos questions à votre médecin directement depuis votre espace patient,<br>recevez des réponses sécurisées et gardez un historique de vos échanges.</p>
        <button class="btn-notify" onclick="sendPrompt('Je veux en savoir plus sur la fonctionnalité de messagerie avec le médecin')">Me notifier au lancement ↗</button>
    </div>



@endsection


</body>
</html>
