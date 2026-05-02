<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Boubbou — Espace Médecin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg:        #f4f6f9;
            --surface:   #ffffff;
            --surface2:  #eef1f6;
            --border:    #e2e6ed;
            --text:      #0f172a;
            --muted:     #64748b;
            --hint:      #94a3b8;
            --blue:      #1d4ed8;
            --blue-lt:   #eff4ff;
            --blue-md:   #93c5fd;
            --teal:      #0d9488;
            --teal-lt:   #f0fdfa;
            --red:       #dc2626;
            --red-lt:    #fef2f2;
            --amber:     #b45309;
            --amber-lt:  #fffbeb;
            --green:     #059669;
            --green-lt:  #ecfdf5;
            --sh:        0 1px 3px rgba(15,23,42,0.06), 0 4px 12px rgba(15,23,42,0.04);
            --sh-md:     0 4px 20px rgba(15,23,42,0.10);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px; flex-shrink: 0;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            padding: 20px 14px;
            position: fixed; height: 100vh; overflow-y: auto;
            z-index: 10;
        }

        .logo-area {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 8px 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 16px;
        }
        .logo-mark {
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--blue); color: #fff;
            display: grid; place-items: center;
            font-size: 16px; flex-shrink: 0;
        }
        .logo-text-main { font-family: 'Crimson Pro', serif; font-size: 16px; font-weight: 600; line-height: 1.15; color: var(--text); }
        .logo-text-sub  { font-size: 10.5px; color: var(--muted); letter-spacing: 0.03em; }

        .nav-group-label {
            font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--hint);
            padding: 0 10px; margin: 14px 0 6px;
        }

        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 8px;
            color: var(--muted); font-size: 13.5px; font-weight: 600;
            cursor: pointer; transition: all 0.16s;
            margin-bottom: 2px;
        }
        .nav-link i { font-size: 15px; width: 18px; flex-shrink: 0; }
        .nav-link:hover { background: var(--surface2); color: var(--text); }
        .nav-link.active { background: var(--blue-lt); color: var(--blue); }
        .nav-link .badge-num {
            margin-left: auto; font-size: 10px; font-weight: 800;
            background: var(--red); color: #fff;
            padding: 1px 6px; border-radius: 10px;
        }

        /* Doctor card in sidebar */
        .doc-card {
            margin-top: auto;
            background: var(--blue-lt);
            border: 1px solid var(--blue-md);
            border-radius: 12px;
            padding: 14px;
        }
        .doc-card-top { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .doc-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--blue); color: #fff;
            display: grid; place-items: center;
            font-size: 14px; font-weight: 800; flex-shrink: 0;
        }
        .doc-name  { font-size: 13px; font-weight: 700; color: var(--text); }
        .doc-spec  { font-size: 11px; color: var(--muted); }
        .doc-stats { display: flex; gap: 10px; }
        .doc-stat  { flex: 1; background: #fff; border-radius: 8px; padding: 7px 10px; text-align: center; }
        .doc-stat-val  { font-size: 16px; font-weight: 800; color: var(--blue); }
        .doc-stat-label{ font-size: 10px; color: var(--muted); margin-top: 1px; }

        /* ── MAIN ── */
        .main { margin-left: 240px; flex: 1; padding: 26px 30px; min-height: 100vh; }

        /* ── TOPBAR ── */
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }
        .greeting { font-family: 'Crimson Pro', serif; font-size: 26px; font-weight: 600; color: var(--text); line-height: 1.2; }
        .greeting em { font-style: italic; color: var(--blue); }
        .topbar-sub { font-size: 13px; color: var(--muted); margin-top: 3px; }

        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-pill {
            display: flex; align-items: center; gap: 7px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 9px; padding: 8px 13px;
            font-size: 12.5px; color: var(--muted);
            box-shadow: var(--sh); cursor: pointer;
            transition: border-color 0.15s;
        }
        .topbar-pill:hover { border-color: var(--blue-md); }
        .topbar-pill i { font-size: 14px; }
        .topbar-pill span { color: var(--text); font-weight: 600; }

        .notif-btn {
            width: 36px; height: 36px; border-radius: 9px;
            background: var(--surface); border: 1px solid var(--border);
            box-shadow: var(--sh);
            display: grid; place-items: center;
            cursor: pointer; color: var(--muted);
            position: relative; font-size: 16px;
            transition: all 0.15s;
        }
        .notif-btn:hover { color: var(--blue); border-color: var(--blue-md); }
        .notif-dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--red); border-radius: 50%;
            border: 2px solid var(--surface);
        }


    </style>

</head>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>




<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-mark"><i class="bi bi-heart-pulse-fill"></i></div>
        <div>
            <div class="logo-text-main">MediCare</div>
            <div class="logo-text-sub">Espace Médecin</div>
        </div>
    </div>

    <div class="nav-group-label">Mon espace</div>
    <div class="nav-link active"><a href="{{ route('medecin.dashboard') }}"><i class="bi bi-grid-1x2"></i>Tableau de bord </a></div>
    <div class="nav-link"><a href="{{route('medecin.dispo.index')}}"><i class="bi bi-calendar-week"></i> Mon planning </a></div>
    <div class="nav-link"><i class="bi bi-person-lines-fill"></i> Mes patients <span class="badge-num">3</span></div>
    <div class="nav-link"><i class="bi bi-folder2-open"></i> Dossiers médicaux</div>

    <div class="nav-group-label">Clinique</div>
    <div class="nav-link"><i class="bi bi-capsule"></i> Ordonnances</div>
    <div class="nav-link"><i class="bi bi-activity"></i> Résultats analyses</div>
    <div class="nav-link"><i class="bi bi-chat-dots"></i> Messagerie <span class="badge-num">5</span></div>

    <div class="nav-group-label">Compte</div>
    <div class="nav-link"><i class="bi bi-gear"></i> Paramètres</div>

    <div style="height: 18px;"></div>

    <div class="doc-card">
        <div class="doc-card-top">
            <div class="doc-avatar">DB</div>
            <div>
                <div class="doc-name">Dr. Boubbou</div>
                <div class="doc-spec">Médecine Générale</div>
            </div>
        </div>
        <div class="doc-stats">
            <div class="doc-stat">
                <div class="doc-stat-val">12</div>
                <div class="doc-stat-label">RDV aujourd'hui</div>
            </div>
            <div class="doc-stat">
                <div class="doc-stat-val">248</div>
                <div class="doc-stat-label">Mes patients</div>
            </div>
        </div>
    </div>
</aside>

<!-- ── MAIN ── -->
<main class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <div class="greeting">Bonjour, <em></em> 👋</div>
            <div class="topbar-sub">Mardi 7 avril 2026 · Vous avez 12 consultations aujourd'hui</div>
        </div>
        <div class="topbar-actions">
            <div class="topbar-pill">
                <i class="bi bi-calendar3" style="color:var(--blue);"></i>
                <span>7 Avril 2026</span>
            </div>
            <div class="topbar-pill" style="background:var(--blue);border-color:var(--blue);color:#fff;">
                <i class="bi bi-plus-lg"></i>
                <span style="color:#fff;">Nouveau RDV</span>
            </div>
            <div class="notif-btn">
                <i class="bi bi-bell"></i>
                <div class="notif-dot"></div>
            </div>
        </div>
    </div>



    @yield('content')

</body>
