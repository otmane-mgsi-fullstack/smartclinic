<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- CSS ici -->
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">

</head>



<body>
@extends('admin::dashboard.layout')


@section('content')




    <div class="kpi-grid">
        <div class="kpi-card blue">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Rendez-vous aujourd'hui</div>
                    <div class="kpi-value">48</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-calendar-check"></i></div>
            </div>
            <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+8%<small>vs semaine dernière</small></div>
        </div>
        <div class="kpi-card green">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Patients actifs</div>
                    <div class="kpi-value">1 245</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-people"></i></div>
            </div>
            <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+3%<small>ce mois</small></div>
        </div>
        <div class="kpi-card amber">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Revenus mensuels</div>
                    <div class="kpi-value">72 300€</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-currency-euro"></i></div>
            </div>
            <div class="kpi-trend up"><i class="bi bi-arrow-up-short"></i>+12%<small>vs mois dernier</small></div>
        </div>
        <div class="kpi-card red">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Factures en attente</div>
                    <div class="kpi-value">19</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="kpi-trend down"><i class="bi bi-arrow-down-short"></i>-5%<small>à régulariser</small></div>
        </div>
    </div>

    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Rendez-vous par mois</div>
                    <div class="card-sub">Évolution des consultations sur 8 mois</div>
                </div>
                <div class="tab-pills">
                    <div class="tab-pill active">Mensuel</div>
                    <div class="tab-pill">Hebdo</div>
                    <div class="tab-pill">Annuel</div>
                </div>
            </div>
            <canvas id="appointmentsChart" height="88"></canvas>
        </div>
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Revenus par service</div>
                    <div class="card-sub">Distribution mensuelle</div>
                </div>
                <i class="bi bi-three-dots" style="color:var(--muted);cursor:pointer;font-size:16px;"></i>
            </div>
            <canvas id="billingChart" height="195"></canvas>
            <div class="chart-legend">
                <div class="cl-item"><span class="cl-dot" style="background:#2563eb;"></span>Cardiologie</div>
                <div class="cl-item"><span class="cl-dot" style="background:#60a5fa;"></span>Radiologie</div>
                <div class="cl-item"><span class="cl-dot" style="background:#bfdbfe;"></span>Pédiatrie</div>
                <div class="cl-item"><span class="cl-dot" style="background:#6b7280;"></span>Urgences</div>
            </div>
        </div>
    </div>

    <div class="bottom-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Derniers rendez-vous</div>
                    <div class="card-sub">Activité récente du cabinet</div>
                </div>
                <button style="background:#eff6ff;color:var(--accent);border:1px solid #bfdbfe;border-radius:8px;padding:7px 14px;font-family:inherit;font-size:12.5px;font-weight:600;cursor:pointer;">
                    Voir tout <i class="bi bi-arrow-right"></i>
                </button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr><th>Patient</th><th>Médecin</th><th>Date</th><th>Service</th><th>Statut</th><th></th></tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><div class="patient-cell"><div class="p-avatar" style="background:#eff6ff;color:#2563eb;">MD</div>Marie Dupont</div></td>
                        <td style="color:var(--muted)">Dr. Martin</td><td>12/04/2026</td>
                        <td style="color:#0ea5e9;font-weight:500;">Cardiologie</td>
                        <td><span class="badge confirmed">Confirmé</span></td>
                        <td><i class="bi bi-three-dots-vertical" style="color:var(--muted);font-size:14px;"></i></td>
                    </tr>
                    <tr>
                        <td><div class="patient-cell"><div class="p-avatar" style="background:#ecfdf5;color:#059669;">AB</div>Ali Ben Salem</div></td>
                        <td style="color:var(--muted)">Dr. Lopez</td><td>12/04/2026</td>
                        <td style="color:#7c3aed;font-weight:500;">Pédiatrie</td>
                        <td><span class="badge pending">En attente</span></td>
                        <td><i class="bi bi-three-dots-vertical" style="color:var(--muted);font-size:14px;"></i></td>
                    </tr>
                    <tr>
                        <td><div class="patient-cell"><div class="p-avatar" style="background:#fef2f2;color:#dc2626;">SB</div>Sophie Bernard</div></td>
                        <td style="color:var(--muted)">Dr. Nguyen</td><td>13/04/2026</td>
                        <td style="color:#d97706;font-weight:500;">Dermatologie</td>
                        <td><span class="badge cancelled">Annulé</span></td>
                        <td><i class="bi bi-three-dots-vertical" style="color:var(--muted);font-size:14px;"></i></td>
                    </tr>
                    <tr>
                        <td><div class="patient-cell"><div class="p-avatar" style="background:#f5f3ff;color:#7c3aed;">KM</div>Karim Mansouri</div></td>
                        <td style="color:var(--muted)">Dr. Boubbou</td><td>14/04/2026</td>
                        <td style="color:#059669;font-weight:500;">Générale</td>
                        <td><span class="badge confirmed">Confirmé</span></td>
                        <td><i class="bi bi-three-dots-vertical" style="color:var(--muted);font-size:14px;"></i></td>
                    </tr>
                    <tr>
                        <td><div class="patient-cell"><div class="p-avatar" style="background:#fffbeb;color:#d97706;">FL</div>Fatima Larbi</div></td>
                        <td style="color:var(--muted)">Dr. Martin</td><td>14/04/2026</td>
                        <td style="color:#2563eb;font-weight:500;">Radiologie</td>
                        <td><span class="badge pending">En attente</span></td>
                        <td><i class="bi bi-three-dots-vertical" style="color:var(--muted);font-size:14px;"></i></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Prochains RDV</div>
                    <div class="card-sub">Aujourd'hui, 7 Avril</div>
                </div>
                <i class="bi bi-plus-lg" style="color:var(--accent);cursor:pointer;font-size:18px;"></i>
            </div>
            <div class="upcoming-list">
                <div class="appt-item">
                    <div class="appt-time-col"><div class="appt-time">09:00</div><div class="appt-period">AM</div></div>
                    <div class="appt-divider" style="background:#2563eb;"></div>
                    <div class="appt-info"><div class="appt-name">Nour El Houda</div><div class="appt-type">Consultation · 30min</div></div>
                    <div class="appt-avatar" style="background:#eff6ff;color:#2563eb;">NH</div>
                </div>
                <div class="appt-item">
                    <div class="appt-time-col"><div class="appt-time">10:30</div><div class="appt-period">AM</div></div>
                    <div class="appt-divider" style="background:#059669;"></div>
                    <div class="appt-info"><div class="appt-name">Youssef Alami</div><div class="appt-type">Cardiologie · 45min</div></div>
                    <div class="appt-avatar" style="background:#ecfdf5;color:#059669;">YA</div>
                </div>
                <div class="appt-item">
                    <div class="appt-time-col"><div class="appt-time">14:00</div><div class="appt-period">PM</div></div>
                    <div class="appt-divider" style="background:#7c3aed;"></div>
                    <div class="appt-info"><div class="appt-name">Amina Benali</div><div class="appt-type">Pédiatrie · 30min</div></div>
                    <div class="appt-avatar" style="background:#f5f3ff;color:#7c3aed;">AB</div>
                </div>
                <div class="appt-item">
                    <div class="appt-time-col"><div class="appt-time">15:30</div><div class="appt-period">PM</div></div>
                    <div class="appt-divider" style="background:#d97706;"></div>
                    <div class="appt-info"><div class="appt-name">Hassan Ouali</div><div class="appt-type">Dermatologie · 20min</div></div>
                    <div class="appt-avatar" style="background:#fffbeb;color:#d97706;">HO</div>
                </div>
                <div class="appt-item">
                    <div class="appt-time-col"><div class="appt-time">16:45</div><div class="appt-period">PM</div></div>
                    <div class="appt-divider" style="background:#dc2626;"></div>
                    <div class="appt-info"><div class="appt-name">Leila Idrissi</div><div class="appt-type">Radiologie · 60min</div></div>
                    <div class="appt-avatar" style="background:#fef2f2;color:#dc2626;">LI</div>
                </div>
            </div>
        </div>
    </div>







@endsection



</body>
</html>
