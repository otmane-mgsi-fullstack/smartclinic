<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Santé</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg:      #f7f9fc;
            --surface: #ffffff;
            --border:  #e8ecf2;
            --text:    #0e1726;
            --muted:   #6b7a99;
            --hint:    #a0acc4;
            --blue:    #1a56db;
            --blue-lt: #eef3ff;
            --blue-md: #93b4f8;
            --green:   #047857;
            --green-lt:#ecfdf5;
            --red:     #be123c;
            --red-lt:  #fff1f3;
            --amber:   #92400e;
            --amber-lt:#fffbeb;
            --sh:      0 1px 3px rgba(14,23,38,.06), 0 3px 10px rgba(14,23,38,.04);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            min-height: 100vh;
            display: flex;
        }

        /* ── NAV LEFT ── */
        .nav {
            width: 72px; flex-shrink: 0;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column; align-items: center;
            padding: 20px 0;
            position: fixed; height: 100vh;
        }
        .nav-logo {
            width: 40px; height: 40px; border-radius: 12px;
            background: var(--blue); color: #fff;
            display: grid; place-items: center;
            font-size: 18px; margin-bottom: 30px;
        }
        .nav-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: grid; place-items: center;
            color: var(--hint); font-size: 18px;
            cursor: pointer; margin-bottom: 6px;
            transition: all 0.16s;
        }
        .nav-icon:hover { background: var(--bg); color: var(--text); }
        .nav-icon.active { background: var(--blue-lt); color: var(--blue); }
        .nav-avatar {
            margin-top: auto;
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg,#818cf8,#6366f1);
            color: #fff; display: grid; place-items: center;
            font-size: 13px; font-weight: 800; cursor: pointer;
        }

        /* ── MAIN ── */
        .main { margin-left: 72px; flex: 1; padding: 30px 32px; }

        /* ── HEADER ── */
        .header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 28px;
        }
        .welcome { font-family: 'Fraunces', serif; font-size: 24px; font-weight: 500; }
        .welcome em { font-style: italic; color: var(--blue); }
        .header-sub { font-size: 13px; color: var(--muted); margin-top: 4px; }

        .header-right { display: flex; align-items: center; gap: 10px; }
        .search {
            display: flex; align-items: center; gap: 8px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 10px; padding: 8px 14px;
            box-shadow: var(--sh);
        }
        .search input { background: none; border: none; outline: none; font-family: inherit; font-size: 13px; color: var(--text); width: 180px; }
        .search input::placeholder { color: var(--hint); }
        .search i { color: var(--hint); font-size: 14px; }

        .notif-btn {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--surface); border: 1px solid var(--border);
            box-shadow: var(--sh);
            display: grid; place-items: center; cursor: pointer;
            color: var(--muted); font-size: 16px; position: relative;
        }
        .nd { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--red); border-radius: 50%; border: 2px solid var(--surface); }

        /* ── PROFILE BANNER ── */
        .profile-banner {
            background: var(--blue);
            border-radius: 16px;
            padding: 22px 26px;
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 22px;
            position: relative; overflow: hidden;
            animation: up 0.4s ease both;
        }
        .profile-banner::after {
            content: '';
            position: absolute; right: -40px; top: -40px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .pb-avatar {
            width: 58px; height: 58px; border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.4);
            display: grid; place-items: center;
            font-family: 'Fraunces', serif;
            font-size: 22px; font-weight: 600; color: #fff;
            flex-shrink: 0;
        }
        .pb-info { flex: 1; }
        .pb-name { font-family: 'Fraunces', serif; font-size: 20px; font-weight: 600; color: #fff; }
        .pb-meta { font-size: 12.5px; color: rgba(255,255,255,0.72); margin-top: 4px; display: flex; gap: 16px; }
        .pb-meta span { display: flex; align-items: center; gap: 5px; }

        .pb-tags { display: flex; gap: 8px; margin-top: 10px; }
        .pb-tag {
            background: rgba(255,255,255,0.15);
            color: #fff; font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .pb-action {
            background: #fff; color: var(--blue);
            border: none; border-radius: 10px;
            padding: 10px 18px; font-family: inherit;
            font-size: 13px; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; gap: 7px;
            white-space: nowrap;
            transition: opacity 0.15s;
        }
        .pb-action:hover { opacity: 0.9; }
</style>
</head>


<body>

<!-- ── NAV ICON ── -->
<nav class="nav">
    <div class="nav-logo"><i class="bi bi-heart-pulse-fill"></i></div>
    <div class="nav-icon active" title="Accueil"><i class="bi bi-grid-1x2-fill"></i></div>
    <div class="nav-icon" title="Rendez-vous"><i class="bi bi-calendar-check"></i></div>
    <div class="nav-icon" title="Dossier"><i class="bi bi-folder2-open"></i></div>
    <div class="nav-icon" title="Analyses"><i class="bi bi-activity"></i></div>
    <div class="nav-icon" title="Médicaments"><i class="bi bi-capsule"></i></div>
    <div class="nav-icon" title="Messagerie"><i class="bi bi-chat-dots"></i></div>
    <div class="nav-avatar">YA</div>
</nav>

<!-- ── MAIN ── -->
<main class="main">

    <!-- HEADER -->
    <div class="header">
        <div>
            <div class="welcome">Bonjour, <em>Youssef</em> 👋</div>
            <div class="header-sub">Mardi 7 avril 2026 · Votre prochain RDV est dans 3 jours</div>
        </div>
        <div class="header-right">
            <div class="search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Rechercher…">
            </div>
            <div class="notif-btn"><i class="bi bi-bell"></i><div class="nd"></div></div>
        </div>
    </div>

    <!-- PROFILE BANNER -->
    <div class="profile-banner">
        <div class="pb-avatar">YA</div>
        <div class="pb-info">
            <div class="pb-name">Youssef Alami</div>
            <div class="pb-meta">
                <span><i class="bi bi-person"></i> 54 ans · Homme</span>
                <span><i class="bi bi-geo-alt"></i> Fès, Maroc</span>
                <span><i class="bi bi-droplet-half"></i> Groupe A+</span>
            </div>
            <div class="pb-tags">
                <span class="pb-tag">HTA</span>
                <span class="pb-tag">Diabète T2</span>
                <span class="pb-tag">Suivi Dr. Boubbou</span>
            </div>
        </div>
        <button class="pb-action"><i class="bi bi-calendar-plus"></i> Prendre RDV</button>
    </div>

    <!-- Content -->
    @yield('content')
