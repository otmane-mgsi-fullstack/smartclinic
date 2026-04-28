
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


    <!-- STATS -->
    <div class="stats4">
        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico blue"><i class="bi bi-calendar-check"></i></div>
                <i class="bi bi-chevron-right" style="color:var(--hint);font-size:13px;"></i>
            </div>
            <div class="scard-label">Prochain RDV</div>
            <div class="scard-val">10 Avr</div>
            <div class="scard-note">Dr. Boubbou · 10h00</div>
        </div>
        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico green"><i class="bi bi-heart-pulse"></i></div>
                <i class="bi bi-chevron-right" style="color:var(--hint);font-size:13px;"></i>
            </div>
            <div class="scard-label">Tension artérielle</div>
            <div class="scard-val">128/82</div>
            <div class="scard-note ok">✓ Contrôlée</div>
        </div>
        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico amber"><i class="bi bi-droplet"></i></div>
                <i class="bi bi-chevron-right" style="color:var(--hint);font-size:13px;"></i>
            </div>
            <div class="scard-label">Glycémie à jeun</div>
            <div class="scard-val">1.28 g/L</div>
            <div class="scard-note warn">⚠ Légèrement élevée</div>
        </div>
        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico red"><i class="bi bi-capsule"></i></div>
                <i class="bi bi-chevron-right" style="color:var(--hint);font-size:13px;"></i>
            </div>
            <div class="scard-label">Médicaments</div>
            <div class="scard-val">3</div>
            <div class="scard-note warn">1 stock faible</div>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">

        <!-- PROCHAINS RDV -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Mes rendez-vous</div>
                    <div class="card-sub">Consultations à venir</div>
                </div>
                <button style="background:var(--blue);color:#fff;border:none;border-radius:8px;padding:7px 14px;font-family:inherit;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                    <i class="bi bi-plus"></i> Nouveau RDV
                </button>
            </div>
            <div class="rdv-list">
                <div class="rdv-item next">
                    <div class="rdv-date-box">
                        <div class="rdv-day">10</div>
                        <div class="rdv-month">Avr</div>
                    </div>
                    <div class="rdv-info">
                        <div class="rdv-title">Consultation générale</div>
                        <div class="rdv-meta">
                            <span><i class="bi bi-person-circle"></i> Dr. Boubbou</span>
                            <span><i class="bi bi-clock"></i> 10:00 – 10:30</span>
                        </div>
                    </div>
                    <span class="rdv-status ok">Confirmé</span>
                </div>
                <div class="rdv-item">
                    <div class="rdv-date-box">
                        <div class="rdv-day">22</div>
                        <div class="rdv-month">Avr</div>
                    </div>
                    <div class="rdv-info">
                        <div class="rdv-title">Bilan sanguin</div>
                        <div class="rdv-meta">
                            <span><i class="bi bi-hospital"></i> Labo Central</span>
                            <span><i class="bi bi-clock"></i> 08:00 – 08:30</span>
                        </div>
                    </div>
                    <span class="rdv-status ok">Confirmé</span>
                </div>
                <div class="rdv-item">
                    <div class="rdv-date-box">
                        <div class="rdv-day">05</div>
                        <div class="rdv-month">Mai</div>
                    </div>
                    <div class="rdv-info">
                        <div class="rdv-title">Suivi cardiologique</div>
                        <div class="rdv-meta">
                            <span><i class="bi bi-person-circle"></i> Dr. Martin</span>
                            <span><i class="bi bi-clock"></i> 14:30 – 15:00</span>
                        </div>
                    </div>
                    <span class="rdv-status att">En attente</span>
                </div>
                <div class="rdv-item">
                    <div class="rdv-date-box">
                        <div class="rdv-day">18</div>
                        <div class="rdv-month">Mai</div>
                    </div>
                    <div class="rdv-info">
                        <div class="rdv-title">Renouvellement ordonnance</div>
                        <div class="rdv-meta">
                            <span><i class="bi bi-person-circle"></i> Dr. Boubbou</span>
                            <span><i class="bi bi-clock"></i> 11:00 – 11:30</span>
                        </div>
                    </div>
                    <span class="rdv-status ok">Confirmé</span>
                </div>
            </div>
        </div>






        <!-- MEDICAMENTS -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Mes médicaments</div>
                    <div class="card-sub">Traitement en cours</div>
                </div>
                <i class="bi bi-three-dots" style="color:var(--muted);font-size:16px;cursor:pointer;"></i>
            </div>
            <div class="med-list">
                <div class="med-item">
                    <div class="med-ico" style="background:#ecfdf5;color:var(--green);">💊</div>
                    <div>
                        <div class="med-name">Metformine</div>
                        <div class="med-dose">500mg · 2× par jour</div>
                    </div>
                    <span class="med-stock ok">28 jours</span>
                </div>
                <div class="med-item">
                    <div class="med-ico" style="background:#eef3ff;color:var(--blue);">💊</div>
                    <div>
                        <div class="med-name">Amlodipine</div>
                        <div class="med-dose">5mg · 1× le matin</div>
                    </div>
                    <span class="med-stock ok">21 jours</span>
                </div>
                <div class="med-item" style="border-color:#fecdd3;">
                    <div class="med-ico" style="background:var(--red-lt);color:var(--red);">💊</div>
                    <div>
                        <div class="med-name">Atorvastatine</div>
                        <div class="med-dose">20mg · 1× le soir</div>
                    </div>
                    <span class="med-stock low">5 jours ⚠</span>
                </div>
            </div>

            <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
                <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">Mes médecins</div>
                <div class="doc-contact">
                    <div class="dc-avatar" style="background:#eef3ff;color:var(--blue);">DB</div>
                    <div>
                        <div class="dc-name">Dr. Boubbou</div>
                        <div class="dc-spec">Médecin traitant</div>
                    </div>
                    <div class="dc-action"><i class="bi bi-telephone"></i></div>
                </div>
                <div class="doc-contact">
                    <div class="dc-avatar" style="background:#ecfdf5;color:var(--green);">MT</div>
                    <div>
                        <div class="dc-name">Dr. Martin</div>
                        <div class="dc-spec">Cardiologue</div>
                    </div>
                    <div class="dc-action"><i class="bi bi-telephone"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM ROW -->
    <div class="bottom-row">

        <!-- ANALYSES -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Résultats d'analyses</div>
                    <div class="card-sub">Derniers bilans — 22 mars 2026</div>
                </div>
                <button style="background:var(--blue-lt);color:var(--blue);border:1px solid var(--blue-md);border-radius:8px;padding:6px 12px;font-family:inherit;font-size:12px;font-weight:700;cursor:pointer;">
                    Voir tout
                </button>
            </div>
            <div class="analyse-list">
                <div class="analyse-item">
                    <div style="width:34px;height:34px;border-radius:9px;background:var(--green-lt);color:var(--green);display:grid;place-items:center;font-size:16px;flex-shrink:0;">🩸</div>
                    <div style="flex:1;">
                        <div class="analyse-name">Hémoglobine</div>
                        <div class="analyse-date">22 mars 2026</div>
                    </div>
                    <div>
                        <div class="analyse-val ok">13.8 g/dL</div>
                        <div class="analyse-bar-wrap" style="margin-top:4px;">
                            <div class="analyse-bar-bg"><div class="analyse-bar-fill" style="width:75%;background:var(--green);"></div></div>
                        </div>
                    </div>
                </div>
                <div class="analyse-item">
                    <div style="width:34px;height:34px;border-radius:9px;background:var(--amber-lt);color:var(--amber);display:grid;place-items:center;font-size:16px;flex-shrink:0;">🔬</div>
                    <div style="flex:1;">
                        <div class="analyse-name">Glycémie HbA1c</div>
                        <div class="analyse-date">22 mars 2026</div>
                    </div>
                    <div>
                        <div class="analyse-val warn">7.2%</div>
                        <div class="analyse-bar-wrap" style="margin-top:4px;">
                            <div class="analyse-bar-bg"><div class="analyse-bar-fill" style="width:62%;background:var(--amber);"></div></div>
                        </div>
                    </div>
                </div>
                <div class="analyse-item">
                    <div style="width:34px;height:34px;border-radius:9px;background:var(--blue-lt);color:var(--blue);display:grid;place-items:center;font-size:16px;flex-shrink:0;">💧</div>
                    <div style="flex:1;">
                        <div class="analyse-name">Cholestérol LDL</div>
                        <div class="analyse-date">22 mars 2026</div>
                    </div>
                    <div>
                        <div class="analyse-val ok">1.05 g/L</div>
                        <div class="analyse-bar-wrap" style="margin-top:4px;">
                            <div class="analyse-bar-bg"><div class="analyse-bar-fill" style="width:45%;background:var(--blue);"></div></div>
                        </div>
                    </div>
                </div>
                <div class="analyse-item">
                    <div style="width:34px;height:34px;border-radius:9px;background:var(--red-lt);color:var(--red);display:grid;place-items:center;font-size:16px;flex-shrink:0;">❤️</div>
                    <div style="flex:1;">
                        <div class="analyse-name">Créatinine</div>
                        <div class="analyse-date">22 mars 2026</div>
                    </div>
                    <div>
                        <div class="analyse-val bad">1.42 mg/dL</div>
                        <div class="analyse-bar-wrap" style="margin-top:4px;">
                            <div class="analyse-bar-bg"><div class="analyse-bar-fill" style="width:85%;background:var(--red);"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HISTORIQUE -->
        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Historique médical</div>
                    <div class="card-sub">Consultations passées</div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0;">

                <div style="display:flex;gap:14px;padding-bottom:16px;position:relative;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:10px;height:10px;border-radius:50%;background:var(--blue);flex-shrink:0;margin-top:3px;"></div>
                        <div style="width:1px;flex:1;background:var(--border);margin-top:4px;"></div>
                    </div>
                    <div style="flex:1;padding-bottom:4px;">
                        <div style="font-size:13px;font-weight:700;">Consultation générale</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:2px;">Dr. Boubbou · Suivi HTA & Diabète</div>
                        <div style="font-size:11px;color:var(--hint);margin-top:3px;">7 avril 2026</div>
                    </div>
                </div>

                <div style="display:flex;gap:14px;padding-bottom:16px;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:10px;height:10px;border-radius:50%;background:var(--green);flex-shrink:0;margin-top:3px;"></div>
                        <div style="width:1px;flex:1;background:var(--border);margin-top:4px;"></div>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;">Bilan sanguin complet</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:2px;">Laboratoire Central · 4 analyses</div>
                        <div style="font-size:11px;color:var(--hint);margin-top:3px;">22 mars 2026</div>
                    </div>
                </div>

                <div style="display:flex;gap:14px;padding-bottom:16px;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:10px;height:10px;border-radius:50%;background:var(--amber);flex-shrink:0;margin-top:3px;"></div>
                        <div style="width:1px;flex:1;background:var(--border);margin-top:4px;"></div>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;">Suivi cardiologique</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:2px;">Dr. Martin · ECG normal</div>
                        <div style="font-size:11px;color:var(--hint);margin-top:3px;">10 mars 2026</div>
                    </div>
                </div>

                <div style="display:flex;gap:14px;padding-bottom:16px;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:10px;height:10px;border-radius:50%;background:var(--blue);flex-shrink:0;margin-top:3px;"></div>
                        <div style="width:1px;flex:1;background:var(--border);margin-top:4px;"></div>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;">Renouvellement ordonnance</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:2px;">Dr. Boubbou · Metformine + Amlodipine</div>
                        <div style="font-size:11px;color:var(--hint);margin-top:3px;">18 fév. 2026</div>
                    </div>
                </div>

                <div style="display:flex;gap:14px;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:10px;height:10px;border-radius:50%;background:var(--hint);flex-shrink:0;margin-top:3px;"></div>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;">Consultation générale</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:2px;">Dr. Boubbou · Contrôle tension</div>
                        <div style="font-size:11px;color:var(--hint);margin-top:3px;">5 janv. 2026</div>
                    </div>
                </div>


@endsection


</body>
</html>
