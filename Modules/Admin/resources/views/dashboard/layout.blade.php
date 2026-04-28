

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Santé</title>

    <link rel="stylesheet" href="{{ asset('css/patient/index.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --bg:       #f5f7fa;
            --surface:  #ffffff;
            --surface2: #f0f2f6;
            --border:   #e5e8ef;
            --text:     #111827;
            --muted:    #6b7280;
            --accent:   #2563eb;
            --accent2:  #0ea5e9;
            --green:    #059669;
            --red:      #dc2626;
            --amber:    #d97706;
            --purple:   #7c3aed;
            --shadow:   0 1px 4px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.05);
            --shadow-sm:0 1px 3px rgba(0,0,0,0.06);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 252px; flex-shrink: 0;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            padding: 24px 16px;
            position: fixed; height: 100vh; overflow-y: auto;
        }
        .logo-wrap { display: flex; align-items: center; gap: 10px; padding: 4px 8px 28px; }
        .logo-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: #eff6ff; border: 1px solid #bfdbfe;
            display: grid; place-items: center; font-size: 18px; flex-shrink: 0;
        }
        .logo-name { font-family: 'Lora', serif; font-size: 15px; font-weight: 600; color: var(--text); line-height: 1.2; }
        .logo-sub  { font-size: 11px; color: var(--muted); margin-top: 1px; }

        .nav-section {
            font-size: 10px; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--muted); padding: 0 8px;
            margin: 18px 0 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px;
            color: var(--muted); cursor: pointer;
            transition: all 0.18s;
            font-size: 13.5px; font-weight: 500;
            margin-bottom: 2px;
        }
        .nav-item i { font-size: 15px; width: 18px; }
        .nav-item:hover { background: var(--surface2); color: var(--text); }
        .nav-item.active { background: #eff6ff; color: var(--accent); font-weight: 600; }
        .nav-badge {
            margin-left: auto; background: var(--red); color: #fff;
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
        }

        .sidebar-stats { margin: 16px 0; display: flex; flex-direction: column; gap: 8px; }
        .ss-card {
            background: var(--surface2); border-radius: 10px; padding: 11px 14px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .ss-label { font-size: 12px; color: var(--muted); }
        .ss-val   { font-size: 15px; font-weight: 700; }

        .sidebar-footer {
            margin-top: auto; padding: 12px 14px;
            background: var(--surface2); border-radius: 10px;
            display: flex; align-items: center; gap: 10px;
        }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg,#6366f1,#7c3aed);
            display: grid; place-items: center;
            font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .sf-name { font-size: 13px; font-weight: 600; }
        .sf-role { font-size: 11px; color: var(--muted); }

        /* MAIN */
        .main { margin-left: 252px; flex: 1; padding: 28px 32px; background: var(--bg); min-height: 100vh; }

        /* TOPBAR */
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
        .topbar-left h2 { font-family: 'Lora', serif; font-size: 22px; font-weight: 600; color: var(--text); }
        .topbar-left p  { color: var(--muted); font-size: 13px; margin-top: 3px; }
        .topbar-right   { display: flex; align-items: center; gap: 12px; }

        .search-box {
            display: flex; align-items: center; gap: 8px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 9px; padding: 9px 14px; width: 260px;
            box-shadow: var(--shadow-sm); transition: border-color 0.2s;
        }
        .search-box:focus-within { border-color: #93c5fd; }
        .search-box input { background: none; border: none; outline: none; color: var(--text); font-family: inherit; font-size: 13.5px; width: 100%; }
        .search-box input::placeholder { color: var(--muted); }
        .search-box i { color: var(--muted); font-size: 14px; }

        .icon-btn {
            width: 38px; height: 38px; border-radius: 9px;
            background: var(--surface); border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: grid; place-items: center;
            cursor: pointer; color: var(--muted);
            transition: all 0.18s; position: relative; font-size: 16px;
        }
        .icon-btn:hover { color: var(--accent); border-color: #93c5fd; }
        .notif-dot {
            position: absolute; top: 8px; right: 8px;
            width: 7px; height: 7px;
            background: var(--red); border-radius: 50%; border: 2px solid var(--surface);
        }

        .date-badge {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 9px; box-shadow: var(--shadow-sm);
            padding: 8px 13px; font-size: 12.5px; color: var(--muted);
            display: flex; align-items: center; gap: 7px;
        }
        .date-badge span { color: var(--text); font-weight: 500; }

        .nav-item a {
            text-decoration: none;   /* enlève le soulignement */
            color: inherit;          /* prend la couleur du parent */
        }

        .nav-item a:visited {
            color: inherit;          /* enlève le violet */
        }

        .nav-item a:hover {
            color: #0d6efd;          /* couleur au survol (optionnel) */
        }
    </style>

</head>
<body>


<aside class="sidebar">
    <div class="logo-wrap">
        <div class="logo-icon">🏥</div>
        <div>
            <div class="logo-name">MediCare Pro</div>
            <div class="logo-sub">Cabinet Dr. Boubbou</div>
        </div>
    </div>

    <div class="nav-section">Principal</div>
    <div class="nav-item active"><a href="{{route('admin.dashboard')}}"><i class="bi bi-speedometer2"></i> Tableau de bord</a></div>
    <div class="nav-item"><i class="bi bi-calendar-check"></i> Rendez-vous <span class="nav-badge">7</span></div>
    <div class="nav-item"><a href="{{route('admin.medecin.index')}}"><i class="bi bi-person"></i> Médecin</a> </div>
    <div class="nav-item"><a href="{{route('admin.patient.index')}}"><i class="bi bi-people"></i> Patients</a></div>
    <div class="nav-item"><i class="bi bi-clipboard2-pulse"></i> Dossiers médicaux</div>

    <div class="nav-section">Gestion</div>
    <div class="nav-item"><i class="bi bi-receipt"></i> Facturation <span class="nav-badge">19</span></div>
    <div class="nav-item"><i class="bi bi-hospital"></i> Services</div>
    <div class="nav-item"><i class="bi bi-bar-chart-line"></i> Rapports</div>

    <div class="nav-section">Système</div>
    <div class="nav-item"><i class="bi bi-shield-check"></i> Sécurité</div>
    <div class="nav-item"><i class="bi bi-gear"></i> Paramètres</div>

    <div class="sidebar-stats">
        <div class="ss-card">
            <span class="ss-label">Lits disponibles</span>
            <span class="ss-val" style="color:var(--green)">12</span>
        </div>
        <div class="ss-card">
            <span class="ss-label">Urgences actives</span>
            <span class="ss-val" style="color:var(--red)">3</span>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="avatar">DB</div>
        <div>
            <div class="sf-name">Dr. Boubbou</div>
            <div class="sf-role">Médecin Chef</div>
        </div>
        <i class="bi bi-three-dots-vertical" style="margin-left:auto;color:var(--muted);cursor:pointer;"></i>
    </div>
</aside>

<main class="main">

    <div class="topbar">
        <div class="topbar-left">
            <h2>Tableau de bord</h2>
            <p>Bienvenue, Dr. Boubbou — aperçu du mardi 7 avril 2026</p>
        </div>
        <div class="topbar-right">
            <div class="date-badge">
                <i class="bi bi-calendar3" style="color:var(--accent);font-size:14px;"></i>
                <span>7 Avril 2026</span>
            </div>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Rechercher patient, facture…">
            </div>
            <div class="icon-btn">
                <i class="bi bi-bell"></i>
                <div class="notif-dot"></div>
            </div>
            <div class="icon-btn" style="background:#eff6ff;border-color:#bfdbfe;color:var(--accent);">
                <i class="bi bi-person"></i>
            </div>
        </div>
    </div>


    @yield('content')
