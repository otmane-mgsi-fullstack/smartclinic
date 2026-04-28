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





    <!-- STAT BAND -->
    <div class="stat-band">
        <div class="stat-card">
            <div class="stat-ico blue"><i class="bi bi-calendar-check"></i></div>
            <div>
                <div class="stat-label">Consultations aujourd'hui</div>
                <div class="stat-val">12</div>
                <div class="stat-note up">4 restantes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico teal"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-label">Patients vus ce mois</div>
                <div class="stat-val">87</div>
                <div class="stat-note up">↑ +11 vs mois dernier</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico amber"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="stat-label">Dossiers en attente</div>
                <div class="stat-val">6</div>
                <div class="stat-note warn">À compléter</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico green"><i class="bi bi-clipboard2-pulse"></i></div>
            <div>
                <div class="stat-label">Ordonnances émises</div>
                <div class="stat-val">34</div>
                <div class="stat-note">Ce mois-ci</div>
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
                    <div class="card-sub">Mardi 7 avril · 12 consultations</div>
                </div>
                <button class="pill-btn"><i class="bi bi-plus"></i> Ajouter</button>
            </div>

            <div class="planning-cols">
                <!-- Heures -->
                <div class="time-col">
                    <div class="time-slot">08:00</div>
                    <div class="time-slot">09:00</div>
                    <div class="time-slot">10:00</div>
                    <div class="time-slot">11:00</div>
                    <div class="time-slot">14:00</div>
                    <div class="time-slot">15:00</div>
                    <div class="time-slot">16:00</div>
                    <div class="time-slot">17:00</div>
                </div>
                <!-- Événements -->
                <div class="events-col">
                    <div class="now-line"></div>

                    <div class="event-slot">
                        <div class="event-card green">
                            <div class="ev-ico">YA</div>
                            <div><div class="ev-name">Youssef Alami</div><div class="ev-detail">Consultation générale · Suivi tension</div></div>
                            <div class="ev-time">08:00 – 08:30</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card blue">
                            <div class="ev-ico">NH</div>
                            <div><div class="ev-name">Nour El Houda</div><div class="ev-detail">Première consultation · Nouveau patient</div></div>
                            <div class="ev-time">09:00 – 09:45</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card teal">
                            <div class="ev-ico">MD</div>
                            <div><div class="ev-name">Marie Dupont</div><div class="ev-detail">Résultats analyses · Bilan sanguin</div></div>
                            <div class="ev-time">10:00 – 10:30</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card amber">
                            <div class="ev-ico">KM</div>
                            <div><div class="ev-name">Karim Mansouri</div><div class="ev-detail">Renouvellement ordonnance · Diabète</div></div>
                            <div class="ev-time">11:00 – 11:30</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card blue">
                            <div class="ev-ico">AB</div>
                            <div><div class="ev-name">Amina Benali</div><div class="ev-detail">Consultation pédiatrique · Vaccins</div></div>
                            <div class="ev-time">14:00 – 14:30</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card red">
                            <div class="ev-ico">HO</div>
                            <div><div class="ev-name">Hassan Ouali</div><div class="ev-detail">Urgence · Douleurs thoraciques</div></div>
                            <div class="ev-time">15:00 – 15:45</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card green">
                            <div class="ev-ico">FL</div>
                            <div><div class="ev-name">Fatima Larbi</div><div class="ev-detail">Suivi post-opératoire · Contrôle</div></div>
                            <div class="ev-time">16:00 – 16:30</div>
                        </div>
                    </div>
                    <div class="event-slot">
                        <div class="event-card teal">
                            <div class="ev-ico">SB</div>
                            <div><div class="ev-name">Sophie Bernard</div><div class="ev-detail">Consultation dermatologique</div></div>
                            <div class="ev-time">17:00 – 17:30</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PATIENTS DU JOUR -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Patients du jour</div>
                    <div class="card-sub">12 consultations prévues</div>
                </div>
                <i class="bi bi-funnel" style="color:var(--muted);font-size:16px;cursor:pointer;"></i>
            </div>
            <div class="patient-list">
                <div class="patient-row">
                    <div class="pt-avatar" style="background:#dbeafe;color:var(--blue);">NH</div>
                    <div>
                        <div class="pt-name">Nour El Houda</div>
                        <div class="pt-info">09:00 · Consultation générale</div>
                    </div>
                    <span class="pt-badge new">Nouveau</span>
                </div>
                <div class="patient-row">
                    <div class="pt-avatar" style="background:#d1fae5;color:var(--green);">YA</div>
                    <div>
                        <div class="pt-name">Youssef Alami</div>
                        <div class="pt-info">08:00 · Suivi tension</div>
                    </div>
                    <span class="pt-badge suivi">Suivi</span>
                </div>
                <div class="patient-row" style="border-color:var(--red);background:var(--red-lt);">
                    <div class="pt-avatar" style="background:#fee2e2;color:var(--red);">HO</div>
                    <div>
                        <div class="pt-name">Hassan Ouali</div>
                        <div class="pt-info">15:00 · Douleurs thoraciques</div>
                    </div>
                    <span class="pt-badge urgence">Urgence</span>
                </div>
                <div class="patient-row">
                    <div class="pt-avatar" style="background:#ccfbf1;color:var(--teal);">MD</div>
                    <div>
                        <div class="pt-name">Marie Dupont</div>
                        <div class="pt-info">10:00 · Bilan sanguin</div>
                    </div>
                    <span class="pt-badge suivi">Suivi</span>
                </div>
                <div class="patient-row">
                    <div class="pt-avatar" style="background:#fef3c7;color:var(--amber);">KM</div>
                    <div>
                        <div class="pt-name">Karim Mansouri</div>
                        <div class="pt-info">11:00 · Renouvellement ordonnance</div>
                    </div>
                    <span class="pt-badge suivi">Suivi</span>
                </div>
                <div class="patient-row">
                    <div class="pt-avatar" style="background:#dbeafe;color:var(--blue);">AB</div>
                    <div>
                        <div class="pt-name">Amina Benali</div>
                        <div class="pt-info">14:00 · Vaccins pédiatriques</div>
                    </div>
                    <span class="pt-badge new">Nouveau</span>
                </div>
                <div class="patient-row">
                    <div class="pt-avatar" style="background:#d1fae5;color:var(--green);">FL</div>
                    <div>
                        <div class="pt-name">Fatima Larbi</div>
                        <div class="pt-info">16:00 · Suivi post-opératoire</div>
                    </div>
                    <span class="pt-badge suivi">Suivi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM GRID : Dossiers + Activité -->
    <div class="bottom-grid">

        <!-- DOSSIERS RECENTS -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Dossiers médicaux récents</div>
                    <div class="card-sub">Dernières mises à jour</div>
                </div>
                <button class="pill-btn">Voir tout <i class="bi bi-arrow-right"></i></button>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Patient</th>
                    <th>Âge</th>
                    <th>Diagnostic</th>
                    <th>Statut</th>
                    <th>MAJ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="font-weight:700;">Youssef Alami</td>
                    <td style="color:var(--muted)">54 ans</td>
                    <td>HTA · Diabète T2</td>
                    <td><span class="status-dot suivi">En suivi</span></td>
                    <td style="color:var(--muted);font-size:12px;">Aujourd'hui</td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Marie Dupont</td>
                    <td style="color:var(--muted)">38 ans</td>
                    <td>Anémie ferriprive</td>
                    <td><span class="status-dot stable">Stable</span></td>
                    <td style="color:var(--muted);font-size:12px;">Hier</td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Hassan Ouali</td>
                    <td style="color:var(--muted)">61 ans</td>
                    <td>Cardiopathie</td>
                    <td><span class="status-dot critique">Critique</span></td>
                    <td style="color:var(--muted);font-size:12px;">Aujourd'hui</td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Fatima Larbi</td>
                    <td style="color:var(--muted)">45 ans</td>
                    <td>Post-op appendicite</td>
                    <td><span class="status-dot stable">Stable</span></td>
                    <td style="color:var(--muted);font-size:12px;">03/04</td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Karim Mansouri</td>
                    <td style="color:var(--muted)">49 ans</td>
                    <td>Diabète T2</td>
                    <td><span class="status-dot suivi">En suivi</span></td>
                    <td style="color:var(--muted);font-size:12px;">01/04</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- ACTIVITE CHART -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Mes consultations</div>
                    <div class="card-sub">Évolution sur 8 semaines</div>
                </div>
                <div class="chart-tabs">
                    <div class="chart-tab active">Semaine</div>
                    <div class="chart-tab">Mois</div>
                </div>
            </div>
            <canvas id="actChart" height="175"></canvas>
        </div>

    </div>
    </main>
@endsection

</body>
</html>
