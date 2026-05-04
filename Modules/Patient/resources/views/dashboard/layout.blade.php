
<style>
    :root {
        --bg:#f7f9fc; --surface:#ffffff; --border:#e8ecf2; --text:#0e1726;
        --muted:#6b7a99; --hint:#a0acc4; --blue:#1a56db; --blue-lt:#eef3ff;
        --blue-md:#93b4f8; --green:#047857; --green-lt:#ecfdf5; --red:#be123c;
        --red-lt:#fff1f3; --amber:#92400e; --amber-lt:#fffbeb;
        --sh:0 1px 3px rgba(14,23,38,.06),0 3px 10px rgba(14,23,38,.04);
    }
    *{box-sizing:border-box;margin:0;padding:0;font-family:inherit}
    body{background:var(--bg);color:var(--text)}
    .dash{display:grid;grid-template-columns:220px 1fr;min-height:100vh;background:var(--bg)}
    .sidebar{background:var(--surface);border-right:.5px solid var(--border);padding:24px 16px;display:flex;flex-direction:column;gap:4px}
    .logo{display:flex;align-items:center;gap:10px;padding:0 8px 20px;border-bottom:.5px solid var(--border);margin-bottom:12px}
    .logo-icon{width:32px;height:32px;border-radius:8px;background:var(--blue);display:flex;align-items:center;justify-content:center}
    .logo-icon svg{width:18px;height:18px;fill:#fff}
    .logo-text{font-size:15px;font-weight:500;color:var(--text)}
    .nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:14px;color:var(--muted);transition:background .15s}
    .nav-item:hover{background:var(--blue-lt);color:var(--blue)}
    .nav-item.active{background:var(--blue-lt);color:var(--blue);font-weight:500}
    .nav-item svg{width:16px;height:16px;flex-shrink:0}
    .nav-badge{margin-left:auto;background:var(--red-lt);color:var(--red);font-size:11px;font-weight:500;padding:2px 7px;border-radius:99px}
    .nav-section{font-size:11px;color:var(--hint);text-transform:uppercase;letter-spacing:.06em;padding:16px 12px 6px;font-weight:500}
    .main{padding:28px 32px;overflow-y:auto}
    .topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px}
    .greeting h1{font-size:20px;font-weight:500;color:var(--text)}
    .greeting p{font-size:14px;color:var(--muted);margin-top:2px}
    .avatar{width:38px;height:38px;border-radius:50%;background:var(--blue-lt);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:500;color:var(--blue);border:.5px solid var(--border)}
    .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
    .stat-card{background:var(--surface);border:.5px solid var(--border);border-radius:12px;padding:18px 20px}
    .stat-label{font-size:12px;color:var(--muted);margin-bottom:8px}
    .stat-val{font-size:26px;font-weight:500;color:var(--text)}
    .stat-sub{font-size:12px;margin-top:4px}
    .stat-green{color:var(--green)}
    .stat-red{color:var(--red)}
    .stat-amber{color:var(--amber)}
    .grid2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
    .card{background:var(--surface);border:.5px solid var(--border);border-radius:12px;padding:20px}
    .card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
    .card-title{font-size:14px;font-weight:500;color:var(--text)}
    .card-link{font-size:12px;color:var(--blue);cursor:pointer}
    .rdv-item{display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:.5px solid var(--border)}
    .rdv-item:last-child{border-bottom:none}
    .rdv-date{background:var(--blue-lt);color:var(--blue);border-radius:8px;padding:6px 10px;text-align:center;min-width:44px;flex-shrink:0}
    .rdv-date .day{font-size:18px;font-weight:500;line-height:1}
    .rdv-date .month{font-size:10px;margin-top:1px}
    .rdv-info{flex:1}
    .rdv-doctor{font-size:13px;font-weight:500;color:var(--text)}
    .rdv-spec{font-size:12px;color:var(--muted);margin-top:1px}
    .rdv-time{font-size:12px;color:var(--hint);margin-top:3px;display:flex;align-items:center;gap:4px}
    .badge{display:inline-block;font-size:11px;padding:2px 8px;border-radius:99px;font-weight:500}
    .badge-green{background:var(--green-lt);color:var(--green)}
    .badge-blue{background:var(--blue-lt);color:var(--blue)}
    .badge-amber{background:var(--amber-lt);color:var(--amber)}
    .badge-red{background:var(--red-lt);color:var(--red)}
    .doc-item{display:flex;align-items:center;gap:12px;padding:9px 0;border-bottom:.5px solid var(--border)}
    .doc-item:last-child{border-bottom:none}
    .doc-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;font-weight:500}
    .doc-pdf{background:var(--red-lt);color:var(--red)}
    .doc-word{background:var(--blue-lt);color:var(--blue)}
    .doc-info{flex:1}
    .doc-name{font-size:13px;font-weight:500;color:var(--text)}
    .doc-date{font-size:11px;color:var(--muted);margin-top:1px}
    .doc-dl{font-size:12px;color:var(--blue);cursor:pointer;flex-shrink:0}
    .msg-coming{background:var(--blue-lt);border:.5px solid var(--blue-md);border-radius:12px;padding:24px;text-align:center}
    .msg-coming svg{width:36px;height:36px;margin:0 auto 12px;color:var(--blue-md)}
    .msg-coming h3{font-size:14px;font-weight:500;color:var(--blue);margin-bottom:6px}
    .msg-coming p{font-size:13px;color:var(--muted);line-height:1.6}
    .msg-coming .btn-notify{display:inline-block;margin-top:14px;background:var(--blue);color:#fff;border:none;border-radius:8px;padding:9px 20px;font-size:13px;cursor:pointer;font-weight:500}
    .btn-rdv{background:var(--blue);color:#fff;border:none;border-radius:8px;padding:9px 16px;font-size:13px;cursor:pointer;font-weight:500;display:flex;align-items:center;gap:6px}
    .btn-rdv svg{width:14px;height:14px;fill:#fff}
    .notif-dot{width:7px;height:7px;border-radius:50%;background:var(--red);flex-shrink:0}
</style>

<div class="dash">
    <nav class="sidebar">
        <div class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2a5 5 0 1 1 0 10A5 5 0 0 1 12 2zm0 12c5.33 0 8 2.67 8 4v2H4v-2c0-1.33 2.67-4 8-4z"/></svg>
            </div>
            <span class="logo-text">MedConnect</span>
        </div>

        <div class="nav-item active">
            <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Tableau de bord
        </div>

        <div class="nav-section">Soins</div>

        <div class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
            Mes rendez-vous
            <span class="nav-badge">2</span>
        </div>

        <div class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
            Mes documents
        </div>

        <div class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-4h2v2h-2zm0-10h2v8h-2z"/></svg>
            Disponibilités
        </div>

        <div class="nav-section">Communication</div>

        <div class="nav-item" style="opacity:.6;cursor:not-allowed">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
            Messages
            <span class="nav-badge" style="background:var(--amber-lt);color:var(--amber)">Bientôt</span>
        </div>

        <div class="nav-section" style="margin-top:auto">Compte</div>
        <div class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
            Mon profil
        </div>
    </nav>

    <main class="main">
        <div class="topbar">
            <div class="greeting">
                <h1>Bonjour, Mohamed</h1>
                <p>Dimanche 3 mai 2026 — voici votre espace santé</p>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
              <a href="{{Route('rdv.index')}}">  <button class="btn-rdv">
                    <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                    Prendre RDV
                  </button> </a>
                <div class="avatar">MH</div>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Prochain rendez-vous</div>
                <div class="stat-val">8 mai</div>
                <div class="stat-sub stat-green">Dr. Alami — Cardiologue</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">RDV à venir</div>
                <div class="stat-val">2</div>
                <div class="stat-sub stat-blue" style="color:var(--blue)">Ce mois-ci</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Documents disponibles</div>
                <div class="stat-val">5</div>
                <div class="stat-sub" style="color:var(--muted)">Ordonnances &amp; rapports</div>
            </div>
        </div>
        <!-- Content -->
    @yield('content')
