<!DOCTYPE html>
<html>
<head>
    <title>Disponibilités</title>
    <link rel="stylesheet" href="{{ asset('css/medecin/disponibilites.css') }}">
</head>

<body>
@extends('medecin::dashboard.layout')

@section('content')

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div>
            <div class="page-title">Mes disponibilités</div>
            <div class="page-sub">Gérez vos créneaux et horaires de consultation</div>
        </div>
        <div class="header-actions">
            <button class="ghost-btn"><i class="bi bi-download"></i> Exporter</button>
            <button class="pill-btn primary" id="btnSave"><i class="bi bi-check2"></i> Enregistrer</button>
        </div>
    </div>

    <!-- STAT BAND -->
    <div class="stat-band">
        <div class="stat-card">
            <div class="stat-ico blue"><i class="bi bi-clock"></i></div>
            <div>
                <div class="stat-label">Créneaux cette semaine</div>
                <div class="stat-val">24</div>
                <div class="stat-note up">6 jours actifs</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico green"><i class="bi bi-calendar2-check"></i></div>
            <div>
                <div class="stat-label">Créneaux disponibles</div>
                <div class="stat-val">18</div>
                <div class="stat-note up">↑ 75% libre</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico amber"><i class="bi bi-calendar2-x"></i></div>
            <div>
                <div class="stat-label">Créneaux réservés</div>
                <div class="stat-val">6</div>
                <div class="stat-note warn">25% occupé</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico teal"><i class="bi bi-person-check"></i></div>
            <div>
                <div class="stat-label">Durée moy. consultation</div>
                <div class="stat-val">30<span style="font-size:15px;font-weight:500"> min</span></div>
                <div class="stat-note">Par défaut</div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="main-grid">

        <!-- WEEK CALENDAR -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Calendrier hebdomadaire</div>
                    <div class="card-sub">Semaine du 7 au 13 Avril 2025</div>
                </div>
                <div class="week-nav">
                    <button class="nav-btn" id="prevWeek"><i class="bi bi-chevron-left"></i></button>
                    <span class="week-label">Sem. 15</span>
                    <button class="nav-btn" id="nextWeek"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>

            <!-- Legend -->
            <div class="legend">
                <div class="legend-item"><span class="dot green"></span> Disponible</div>
                <div class="legend-item"><span class="dot amber"></span> Réservé</div>
                <div class="legend-item"><span class="dot muted"></span> Fermé</div>
                <div class="legend-item"><span class="dot red"></span> Indisponible</div>
            </div>

            <!-- Week grid -->
            <div class="week-grid">
                <!-- Header row -->
                <div class="wg-corner"></div>
                <div class="wg-day-hd">
                    <div class="day-name">Lun</div>
                    <div class="day-num today">7</div>
                </div>
                <div class="wg-day-hd">
                    <div class="day-name">Mar</div>
                    <div class="day-num">8</div>
                </div>
                <div class="wg-day-hd">
                    <div class="day-name">Mer</div>
                    <div class="day-num">9</div>
                </div>
                <div class="wg-day-hd">
                    <div class="day-name">Jeu</div>
                    <div class="day-num">10</div>
                </div>
                <div class="wg-day-hd">
                    <div class="day-name">Ven</div>
                    <div class="day-num">11</div>
                </div>
                <div class="wg-day-hd">
                    <div class="day-name">Sam</div>
                    <div class="day-num">12</div>
                </div>
                <div class="wg-day-hd off">
                    <div class="day-name">Dim</div>
                    <div class="day-num">13</div>
                </div>

                <!-- Time rows -->
                <!-- 08:00 -->
                <div class="wg-time">08:00</div>
                <div class="wg-cell available" data-day="lun" data-time="08:00"><span>08:00</span></div>
                <div class="wg-cell available" data-day="mar" data-time="08:00"><span>08:00</span></div>
                <div class="wg-cell available" data-day="mer" data-time="08:00"><span>08:00</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="08:00"><span>08:00</span></div>
                <div class="wg-cell available" data-day="ven" data-time="08:00"><span>08:00</span></div>
                <div class="wg-cell closed" data-day="sam" data-time="08:00"><span>–</span></div>
                <div class="wg-cell off" data-day="dim" data-time="08:00"><span>–</span></div>

                <!-- 09:00 -->
                <div class="wg-time">09:00</div>
                <div class="wg-cell booked" data-day="lun" data-time="09:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="mar" data-time="09:00"><span>09:00</span></div>
                <div class="wg-cell booked" data-day="mer" data-time="09:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="09:00"><span>09:00</span></div>
                <div class="wg-cell available" data-day="ven" data-time="09:00"><span>09:00</span></div>
                <div class="wg-cell closed" data-day="sam" data-time="09:00"><span>–</span></div>
                <div class="wg-cell off" data-day="dim" data-time="09:00"><span>–</span></div>

                <!-- 10:00 -->
                <div class="wg-time">10:00</div>
                <div class="wg-cell available" data-day="lun" data-time="10:00"><span>10:00</span></div>
                <div class="wg-cell booked" data-day="mar" data-time="10:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="mer" data-time="10:00"><span>10:00</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="10:00"><span>10:00</span></div>
                <div class="wg-cell unavailable" data-day="ven" data-time="10:00"><span>Indispo</span></div>
                <div class="wg-cell closed" data-day="sam" data-time="10:00"><span>–</span></div>
                <div class="wg-cell off" data-day="dim" data-time="10:00"><span>–</span></div>

                <!-- 11:00 -->
                <div class="wg-time">11:00</div>
                <div class="wg-cell available" data-day="lun" data-time="11:00"><span>11:00</span></div>
                <div class="wg-cell available" data-day="mar" data-time="11:00"><span>11:00</span></div>
                <div class="wg-cell booked" data-day="mer" data-time="11:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="11:00"><span>11:00</span></div>
                <div class="wg-cell unavailable" data-day="ven" data-time="11:00"><span>Indispo</span></div>
                <div class="wg-cell closed" data-day="sam" data-time="11:00"><span>–</span></div>
                <div class="wg-cell off" data-day="dim" data-time="11:00"><span>–</span></div>

                <!-- 14:00 -->
                <div class="wg-time">14:00</div>
                <div class="wg-cell booked" data-day="lun" data-time="14:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="mar" data-time="14:00"><span>14:00</span></div>
                <div class="wg-cell available" data-day="mer" data-time="14:00"><span>14:00</span></div>
                <div class="wg-cell booked" data-day="jeu" data-time="14:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="ven" data-time="14:00"><span>14:00</span></div>
                <div class="wg-cell available" data-day="sam" data-time="14:00"><span>14:00</span></div>
                <div class="wg-cell off" data-day="dim" data-time="14:00"><span>–</span></div>

                <!-- 15:00 -->
                <div class="wg-time">15:00</div>
                <div class="wg-cell available" data-day="lun" data-time="15:00"><span>15:00</span></div>
                <div class="wg-cell available" data-day="mar" data-time="15:00"><span>15:00</span></div>
                <div class="wg-cell available" data-day="mer" data-time="15:00"><span>15:00</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="15:00"><span>15:00</span></div>
                <div class="wg-cell available" data-day="ven" data-time="15:00"><span>15:00</span></div>
                <div class="wg-cell available" data-day="sam" data-time="15:00"><span>15:00</span></div>
                <div class="wg-cell off" data-day="dim" data-time="15:00"><span>–</span></div>

                <!-- 16:00 -->
                <div class="wg-time">16:00</div>
                <div class="wg-cell available" data-day="lun" data-time="16:00"><span>16:00</span></div>
                <div class="wg-cell booked" data-day="mar" data-time="16:00"><span>Réservé</span></div>
                <div class="wg-cell available" data-day="mer" data-time="16:00"><span>16:00</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="16:00"><span>16:00</span></div>
                <div class="wg-cell available" data-day="ven" data-time="16:00"><span>16:00</span></div>
                <div class="wg-cell available" data-day="sam" data-time="16:00"><span>16:00</span></div>
                <div class="wg-cell off" data-day="dim" data-time="16:00"><span>–</span></div>

                <!-- 17:00 -->
                <div class="wg-time">17:00</div>
                <div class="wg-cell available" data-day="lun" data-time="17:00"><span>17:00</span></div>
                <div class="wg-cell available" data-day="mar" data-time="17:00"><span>17:00</span></div>
                <div class="wg-cell closed" data-day="mer" data-time="17:00"><span>–</span></div>
                <div class="wg-cell available" data-day="jeu" data-time="17:00"><span>17:00</span></div>
                <div class="wg-cell closed" data-day="ven" data-time="17:00"><span>–</span></div>
                <div class="wg-cell closed" data-day="sam" data-time="17:00"><span>–</span></div>
                <div class="wg-cell off" data-day="dim" data-time="17:00"><span>–</span></div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-col">

            <!-- QUICK SETTINGS -->
            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-title">Paramètres rapides</div>
                        <div class="card-sub">Horaires habituels</div>
                    </div>
                    <i class="bi bi-gear" style="color:var(--muted);font-size:16px;cursor:pointer;"></i>
                </div>

                <div class="settings-group">
                    <div class="settings-label">Jours de travail</div>
                    <div class="day-toggles">
                        <button class="day-tog active">L</button>
                        <button class="day-tog active">M</button>
                        <button class="day-tog active">Me</button>
                        <button class="day-tog active">J</button>
                        <button class="day-tog active">V</button>
                        <button class="day-tog partial">S</button>
                        <button class="day-tog">D</button>
                    </div>
                </div>

                <div class="settings-group">
                    <div class="settings-label">Plage matin</div>
                    <div class="time-range">
                        <div class="time-input-wrap">
                            <label>Début</label>
                            <input type="time" class="time-input" value="08:00">
                        </div>
                        <div class="time-sep">→</div>
                        <div class="time-input-wrap">
                            <label>Fin</label>
                            <input type="time" class="time-input" value="12:00">
                        </div>
                    </div>
                </div>

                <div class="settings-group">
                    <div class="settings-label">Plage après-midi</div>
                    <div class="time-range">
                        <div class="time-input-wrap">
                            <label>Début</label>
                            <input type="time" class="time-input" value="14:00">
                        </div>
                        <div class="time-sep">→</div>
                        <div class="time-input-wrap">
                            <label>Fin</label>
                            <input type="time" class="time-input" value="18:00">
                        </div>
                    </div>
                </div>

                <div class="settings-group">
                    <div class="settings-label">Durée d'un créneau</div>
                    <div class="slot-options">
                        <button class="slot-opt">15 min</button>
                        <button class="slot-opt active">30 min</button>
                        <button class="slot-opt">45 min</button>
                        <button class="slot-opt">60 min</button>
                    </div>
                </div>

                <button class="apply-btn" id="btnApply">
                    <i class="bi bi-arrow-repeat"></i> Appliquer à la semaine
                </button>
            </div>

            <!-- EXCEPTIONS -->
            <div class="card">
                <div class="card-hd">
                    <div>
                        <div class="card-title">Exceptions & congés</div>
                        <div class="card-sub">Indisponibilités planifiées</div>
                    </div>
                    <button class="pill-btn" id="btnAddExc"><i class="bi bi-plus"></i></button>
                </div>

                <div class="exception-list">
                    <div class="exception-item">
                        <div class="exc-ico red"><i class="bi bi-x-circle"></i></div>
                        <div>
                            <div class="exc-title">Formation continue</div>
                            <div class="exc-date">10 Avril – 11 Avril 2025</div>
                        </div>
                        <button class="exc-del"><i class="bi bi-trash3"></i></button>
                    </div>
                    <div class="exception-item">
                        <div class="exc-ico amber"><i class="bi bi-calendar-minus"></i></div>
                        <div>
                            <div class="exc-title">Demi-journée – RDV personnel</div>
                            <div class="exc-date">14 Avril 2025 · Matin</div>
                        </div>
                        <button class="exc-del"><i class="bi bi-trash3"></i></button>
                    </div>
                    <div class="exception-item">
                        <div class="exc-ico blue"><i class="bi bi-airplane"></i></div>
                        <div>
                            <div class="exc-title">Congé annuel</div>
                            <div class="exc-date">28 Avril – 5 Mai 2025</div>
                        </div>
                        <button class="exc-del"><i class="bi bi-trash3"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- BOTTOM GRID -->
    <div class="bottom-grid">

        <!-- RECURRING RULES -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Règles récurrentes</div>
                    <div class="card-sub">Automatisez vos disponibilités</div>
                </div>
                <button class="pill-btn" id="btnAddRule"><i class="bi bi-plus"></i> Nouvelle règle</button>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Règle</th>
                    <th>Jours</th>
                    <th>Horaire</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="font-weight:700;">Consultation matin</td>
                    <td style="color:var(--muted)">Lun – Ven</td>
                    <td>08:00 – 12:00</td>
                    <td><span class="status-dot stable">Actif</span></td>
                    <td><button class="row-btn"><i class="bi bi-pencil"></i></button></td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Consultation après-midi</td>
                    <td style="color:var(--muted)">Lun – Ven</td>
                    <td>14:00 – 18:00</td>
                    <td><span class="status-dot stable">Actif</span></td>
                    <td><button class="row-btn"><i class="bi bi-pencil"></i></button></td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Samedi matin</td>
                    <td style="color:var(--muted)">Samedi</td>
                    <td>14:00 – 17:00</td>
                    <td><span class="status-dot suivi">Partiel</span></td>
                    <td><button class="row-btn"><i class="bi bi-pencil"></i></button></td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Urgences</td>
                    <td style="color:var(--muted)">Lun, Mer, Ven</td>
                    <td>12:00 – 13:00</td>
                    <td><span class="status-dot critique">Inactif</span></td>
                    <td><button class="row-btn"><i class="bi bi-pencil"></i></button></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- UPCOMING BOOKED -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Prochains créneaux réservés</div>
                    <div class="card-sub">Rendez-vous confirmés</div>
                </div>
                <button class="pill-btn">Voir tout <i class="bi bi-arrow-right"></i></button>
            </div>
            <div class="upcoming-list">
                <div class="upcoming-item">
                    <div class="up-time">
                        <div class="up-day">Lun 7</div>
                        <div class="up-hour">09:00</div>
                    </div>
                    <div class="up-bar blue"></div>
                    <div>
                        <div class="up-name">Nour El Houda</div>
                        <div class="up-detail">Consultation générale · 30 min</div>
                    </div>
                    <span class="pt-badge new" style="margin-left:auto">Nouveau</span>
                </div>
                <div class="upcoming-item">
                    <div class="up-time">
                        <div class="up-day">Lun 7</div>
                        <div class="up-hour">14:00</div>
                    </div>
                    <div class="up-bar amber"></div>
                    <div>
                        <div class="up-name">Karim Mansouri</div>
                        <div class="up-detail">Renouvellement ordonnance · 30 min</div>
                    </div>
                    <span class="pt-badge suivi" style="margin-left:auto">Suivi</span>
                </div>
                <div class="upcoming-item">
                    <div class="up-time">
                        <div class="up-day">Mar 8</div>
                        <div class="up-hour">10:00</div>
                    </div>
                    <div class="up-bar teal"></div>
                    <div>
                        <div class="up-name">Marie Dupont</div>
                        <div class="up-detail">Bilan sanguin · 30 min</div>
                    </div>
                    <span class="pt-badge suivi" style="margin-left:auto">Suivi</span>
                </div>
                <div class="upcoming-item">
                    <div class="up-time">
                        <div class="up-day">Mer 9</div>
                        <div class="up-hour">09:00</div>
                    </div>
                    <div class="up-bar red"></div>
                    <div>
                        <div class="up-name">Hassan Ouali</div>
                        <div class="up-detail">Urgence cardiaque · 45 min</div>
                    </div>
                    <span class="pt-badge urgence" style="margin-left:auto">Urgence</span>
                </div>
                <div class="upcoming-item">
                    <div class="up-time">
                        <div class="up-day">Jeu 10</div>
                        <div class="up-hour">14:00</div>
                    </div>
                    <div class="up-bar green"></div>
                    <div>
                        <div class="up-name">Fatima Larbi</div>
                        <div class="up-detail">Suivi post-op · 30 min</div>
                    </div>
                    <span class="pt-badge suivi" style="margin-left:auto">Suivi</span>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL: Add Exception -->
    <div class="modal-overlay" id="modalExc">
        <div class="modal-box">
            <div class="modal-hd">
                <div class="modal-title">Ajouter une exception</div>
                <button class="modal-close" id="closeExc"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Motif</label>
                    <input type="text" class="form-ctrl" placeholder="Ex: Formation, congé, personnel...">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date début</label>
                        <input type="date" class="form-ctrl">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date fin</label>
                        <input type="date" class="form-ctrl">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select class="form-ctrl">
                        <option>Journée complète</option>
                        <option>Matin uniquement</option>
                        <option>Après-midi uniquement</option>
                        <option>Créneau personnalisé</option>
                    </select>
                </div>
            </div>
            <div class="modal-ft">
                <button class="ghost-btn" id="cancelExc">Annuler</button>
                <button class="pill-btn primary">Confirmer</button>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div class="toast" id="toast">
        <i class="bi bi-check-circle-fill"></i>
        <span>Disponibilités enregistrées avec succès</span>
    </div>

@endsection

</body>
</html>
