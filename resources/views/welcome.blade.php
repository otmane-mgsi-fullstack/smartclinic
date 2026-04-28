

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cabinet Boubbou</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>







<!-- ══ NAV ══ -->
<nav>
    <a class="nav-brand" href="#">
        <div class="nav-brand-mark"><i class="bi bi-heart-pulse-fill"></i></div>
        <span class="nav-brand-name">Cabinet Boubbou</span>
    </a>
    <div class="nav-links">
        <a class="nav-link" href="#services">Services</a>
        <a class="nav-link" href="#equipe">Notre équipe</a>
        <a class="nav-link" href="#horaires">Horaires</a>
        <a class="nav-link" href="#horaires">Contact</a>
    </div>
    <button class="nav-cta" onclick="openModal()">
        <a href="{{ route('login') }}" ><i class="bi bi-calendar-plus"></i> Prendre RDV</a>
    </button>
</nav>

<!-- ══ HERO ══ -->
<section class="hero" id="home">
    <div class="hero-left">
        <div class="hero-eyebrow">Cabinet médical · Fès, Maroc</div>
        <h1 class="hero-h1">Une médecine<br>à taille <em>humaine.</em></h1>
        <p class="hero-desc">Consultations générales, suivi des maladies chroniques et renouvellement d'ordonnances. Une prise en charge attentive, pour vous et votre famille.</p>
        <div class="hero-actions">
            <button class="btn-primary" onclick="openModal()">
                <i class="bi bi-calendar-plus"></i> Prendre rendez-vous
            </button>
            <button class="btn-outline">
                <i class="bi bi-telephone"></i> +212 535 XX XX XX
            </button>
        </div>
        <div class="hero-trust">
            <div class="trust-avatars">
                <div class="trust-avatar">MA</div>
                <div class="trust-avatar">KA</div>
                <div class="trust-avatar">SB</div>
                <div class="trust-avatar">RA</div>
            </div>
            <div class="trust-text"><strong>+3 500 patients</strong> nous font confiance</div>
        </div>
    </div>
    <div class="hero-right">
        <div class="fc-pill">
            <div class="fc-pill-dot"></div> Disponible aujourd'hui
        </div>
        <div class="card-cluster">
            <div class="fc-main">
                <div class="fc-doc-row">
                    <div class="fc-ava">DB</div>
                    <div>
                        <div class="fc-name">Dr. Boubbou</div>
                        <div class="fc-spec">Médecin généraliste · 12 ans d'expérience</div>
                    </div>
                </div>
                <div class="fc-stat-row">
                    <div class="fc-stat"><div class="fc-stat-val">3.5k</div><div class="fc-stat-lbl">Patients</div></div>
                    <div class="fc-stat"><div class="fc-stat-val">12</div><div class="fc-stat-lbl">Ans exp.</div></div>
                    <div class="fc-stat"><div class="fc-stat-val">4.9</div><div class="fc-stat-lbl">Note</div></div>
                </div>
            </div>
            <div class="fc-small">
                <div class="fc-small-ico"><i class="bi bi-calendar-check"></i></div>
                <div>
                    <div class="fc-small-title">Prochain créneau</div>
                    <div class="fc-small-sub">Aujourd'hui · 14h30</div>
                </div>
                <div class="fc-small-badge">Libre</div>
            </div>
        </div>
    </div>
</section>

<!-- ══ SERVICES ══ -->
<section id="services">
    <div class="section-inner">
        <div class="services-layout">
            <div class="services-text">
                <div class="section-label">Nos services</div>
                <h2 class="section-h2">Des soins pour<br>toute la <em>famille.</em></h2>
                <p class="section-sub">Du diagnostic à la prévention, nous vous accompagnons à chaque étape de votre parcours de santé avec une approche globale et bienveillante.</p>
                <div style="margin-top:32px;">
                    <button class="btn-primary" onclick="openModal()"><i class="bi bi-calendar-plus"></i> Consulter maintenant</button>
                </div>
            </div>
            <div class="services-grid-r">
                <div class="srv" style="animation:fadeUp .4s .05s both">
                    <div class="srv-ico" style="background:#eef3ff;color:var(--blue);">🩺</div>
                    <div class="srv-name">Médecine générale</div>
                    <div class="srv-desc">Diagnostic et traitement des pathologies courantes pour toute la famille.</div>
                </div>
                <div class="srv featured" style="animation:fadeUp .4s .10s both">
                    <div class="srv-ico"><span>🩸</span></div>
                    <div class="srv-name">Suivi HTA & Diabète</div>
                    <div class="srv-desc">Suivi régulier des maladies chroniques avec bilans et conseils personnalisés.</div>
                </div>
                <div class="srv" style="animation:fadeUp .4s .15s both">
                    <div class="srv-ico" style="background:#ecfdf5;color:var(--green);">💊</div>
                    <div class="srv-name">Ordonnances</div>
                    <div class="srv-desc">Renouvellement rapide de vos traitements habituels.</div>
                </div>
                <div class="srv" style="animation:fadeUp .4s .20s both">
                    <div class="srv-ico" style="background:#fffbeb;color:var(--amber);">📋</div>
                    <div class="srv-name">Bilan & Prévention</div>
                    <div class="srv-desc">Bilan annuel complet et accompagnement préventif personnalisé.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ STATS ══ -->
<section id="stats">
    <div class="stats-inner">
        <div class="stat-item">
            <div class="stat-num">12<span class="stat-suffix">+</span></div>
            <div class="stat-lbl">Années d'expérience</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">3<span class="stat-suffix">500</span></div>
            <div class="stat-lbl">Patients suivis</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">6<span class="stat-suffix">j/7</span></div>
            <div class="stat-lbl">Jours d'ouverture</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">4.9<span class="stat-suffix">★</span></div>
            <div class="stat-lbl">Satisfaction patients</div>
        </div>
    </div>
</section>

<!-- ══ PROCESS ══ -->
<section id="process">
    <div class="section-inner">
        <div class="process-header">
            <div class="section-label">Comment ça marche</div>
            <h2 class="section-h2">RDV en <em>2 minutes</em></h2>
            <p class="section-sub">Réservez votre consultation sans file d'attente, depuis votre téléphone ou ordinateur.</p>
        </div>
        <div class="process-steps">
            <div class="ps">
                <div class="ps-num active-step">1</div>
                <div class="ps-title">Choisissez un médecin</div>
                <div class="ps-desc">Sélectionnez le praticien adapté à votre besoin parmi notre équipe.</div>
            </div>
            <div class="ps">
                <div class="ps-num active-step">2</div>
                <div class="ps-title">Sélectionnez un créneau</div>
                <div class="ps-desc">Consultez les disponibilités en temps réel et choisissez votre heure.</div>
            </div>
            <div class="ps">
                <div class="ps-num active-step">3</div>
                <div class="ps-title">Renseignez vos infos</div>
                <div class="ps-desc">Nom, téléphone et motif de consultation. Simple et rapide.</div>
            </div>
            <div class="ps">
                <div class="ps-num active-step">4</div>
                <div class="ps-title">Confirmation SMS</div>
                <div class="ps-desc">Vous recevez un rappel automatique 24h avant votre rendez-vous.</div>
            </div>
        </div>
        <div style="text-align:center;margin-top:48px;">
            <button class="btn-primary" onclick="openModal()"><i class="bi bi-calendar-plus"></i> Réserver maintenant</button>
        </div>
    </div>
</section>

<!-- ══ ÉQUIPE ══ -->
<section id="equipe">
    <div class="section-inner">
        <div class="team-layout">
            <div class="team-visual">
                <div class="tv-card">
                    <div class="tv-top">
                        <div class="tv-ava">DB</div>
                        <div>
                            <div class="tv-name">Dr. Boubbou</div>
                            <div class="tv-spec">Médecin généraliste agréé</div>
                        </div>
                    </div>
                    <div class="tv-tags">
                        <span class="tv-tag">Médecine générale</span>
                        <span class="tv-tag">HTA & Diabète</span>
                        <span class="tv-tag">Pédiatrie</span>
                    </div>
                    <div class="tv-divider"></div>
                    <div class="tv-row"><i class="bi bi-mortarboard-fill"></i> Faculté de Médecine de Fès — 2012</div>
                    <div class="tv-row"><i class="bi bi-geo-alt-fill"></i> 14, Rue Ibn Khaldoun, Fès-Médina</div>
                    <div class="tv-row"><i class="bi bi-translate"></i> Arabe · Français · Darija</div>
                </div>
            </div>
            <div class="team-text">
                <div class="section-label">Notre équipe</div>
                <h2 class="section-h2">Un médecin<br>à votre <em>écoute.</em></h2>
                <p class="section-sub">Le Dr. Boubbou exerce depuis plus de 12 ans avec une approche centrée sur le patient : écoute, disponibilité et suivi personnalisé.</p>
                <div class="team-qual">
                    <div class="qual-item">
                        <div class="qual-ico" style="background:var(--blue-lt);color:var(--blue);">🎓</div>
                        <div>
                            <div class="qual-title">Diplôme de médecine générale</div>
                            <div class="qual-desc">Faculté de Médecine et de Pharmacie de Fès, promotion 2012.</div>
                        </div>
                    </div>
                    <div class="qual-item">
                        <div class="qual-ico" style="background:var(--green-lt);color:var(--green);">❤️</div>
                        <div>
                            <div class="qual-title">Spécialisation maladies chroniques</div>
                            <div class="qual-desc">Formation avancée en HTA, diabète et maladies cardiovasculaires.</div>
                        </div>
                    </div>
                    <div class="qual-item">
                        <div class="qual-ico" style="background:var(--amber-lt);color:var(--amber);">🌍</div>
                        <div>
                            <div class="qual-title">Cabinet agréé Ministère de la Santé</div>
                            <div class="qual-desc">Cabinet conventionné CNSS · CNOPS · Mutuelles partenaires.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ HORAIRES & CONTACT ══ -->
<section id="horaires" style="background:var(--bg);">
    <div class="section-inner">
        <div style="text-align:center;margin-bottom:56px;">
            <div class="section-label" style="justify-content:center;"><span style="width:20px;height:2px;background:var(--blue);border-radius:2px;display:inline-block;margin-right:8px;"></span>Horaires & Contact</div>
            <h2 class="section-h2" style="margin:0 auto 12px;">Toujours <em>disponibles</em></h2>
            <p class="section-sub" style="margin:0 auto;text-align:center;">Cabinet ouvert 6 jours sur 7. Urgences sur appel.</p>
        </div>
        <div class="horaires-layout">
            <div class="hor-table">
                <div class="hor-row today-row">
                    <span class="hor-day">Lundi <span class="hor-today-badge">Aujourd'hui</span></span>
                    <span class="hor-time" style="color:var(--blue);font-weight:800;">09h – 12h30 · 15h – 18h</span>
                </div>
                <div class="hor-row"><span class="hor-day">Mardi</span><span class="hor-time">09h – 12h30 · 15h – 18h</span></div>
                <div class="hor-row"><span class="hor-day">Mercredi</span><span class="hor-time">09h – 12h30 · 15h – 18h</span></div>
                <div class="hor-row"><span class="hor-day">Jeudi</span><span class="hor-time">09h – 12h30 · 15h – 18h</span></div>
                <div class="hor-row"><span class="hor-day">Vendredi</span><span class="hor-time">09h – 12h · 15h – 18h</span></div>
                <div class="hor-row"><span class="hor-day">Samedi</span><span class="hor-time">09h – 13h</span></div>
                <div class="hor-row"><span class="hor-day">Dimanche</span><span class="hor-closed">Fermé</span></div>
            </div>
            <div class="contact-block">
                <div class="cb-item">
                    <div class="cb-ico" style="background:var(--blue-lt);color:var(--blue);"><i class="bi bi-telephone-fill"></i></div>
                    <div><div class="cb-label">Téléphone</div><div class="cb-val">+212 535 XX XX XX</div></div>
                    <div class="cb-arr"><i class="bi bi-arrow-right"></i></div>
                </div>
                <div class="cb-item">
                    <div class="cb-ico" style="background:#ecfdf5;color:var(--green);"><i class="bi bi-whatsapp"></i></div>
                    <div><div class="cb-label">WhatsApp</div><div class="cb-val">+212 6XX XX XX XX</div></div>
                    <div class="cb-arr"><i class="bi bi-arrow-right"></i></div>
                </div>
                <div class="cb-item">
                    <div class="cb-ico" style="background:var(--blue-lt);color:var(--blue);"><i class="bi bi-envelope-fill"></i></div>
                    <div><div class="cb-label">Email</div><div class="cb-val">cabinet.boubbou@gmail.com</div></div>
                    <div class="cb-arr"><i class="bi bi-arrow-right"></i></div>
                </div>
                <div class="cb-item">
                    <div class="cb-ico" style="background:var(--amber-lt);color:var(--amber);"><i class="bi bi-geo-alt-fill"></i></div>
                    <div><div class="cb-label">Adresse</div><div class="cb-val">14, Rue Ibn Khaldoun, Fès-Médina</div></div>
                    <div class="cb-arr"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ CTA ══ -->
<section id="rdv-cta">
    <div class="cta-inner">
        <h2 class="cta-h2">Votre santé<br>ne peut pas <em>attendre.</em></h2>
        <p class="cta-sub">Réservez votre consultation en ligne, 24h/24, 7j/7.</p>
        <button class="cta-btn" onclick="openModal()">
            <i class="bi bi-calendar-plus"></i> Prendre rendez-vous maintenant
        </button>
    </div>
</section>

<!-- ══ FOOTER ══ -->
<footer>
    <div class="footer-brand">Cabinet <span>Boubbou</span> · Médecine Générale</div>
    <div class="footer-links">
        <a class="footer-link" href="#">Mentions légales</a>
        <a class="footer-link" href="#">Politique de confidentialité</a>
        <a class="footer-link" href="#">Espace patient</a>
    </div>
    <div class="footer-copy">© 2026 · Fès, Maroc</div>
</footer>

<!-- ══════════ MODAL RDV ══════════ -->
<div class="modal-overlay" id="overlay" onclick="bgClose(event)">
    <div class="modal" id="modal">
        <div class="modal-hd">
            <div>
                <div class="modal-eyebrow" id="mEye">Étape 1 sur 3</div>
                <div class="modal-title" id="mTitle">Choisir un médecin & une date</div>
            </div>
            <div class="modal-close" onclick="closeModal()"><i class="bi bi-x-lg"></i></div>
        </div>
        <div class="modal-dots">
            <div class="mdot active" id="d1"></div>
            <div class="mdot" id="d2"></div>
            <div class="mdot" id="d3"></div>
        </div>
        <div class="modal-body">

            <!-- STEP 1 -->
            <div class="sp show" id="sp1">
                <span class="lbl-sm" style="margin-top:4px;">Médecin</span>
                <div class="m-docs">
                    <div class="m-doc" onclick="pickDoc(this,'Dr. Boubbou','Médecin généraliste','150 MAD','linear-gradient(135deg,#3b82f6,#1a56db)')">
                        <div class="m-ava" style="background:linear-gradient(135deg,#3b82f6,#1a56db);">DB</div>
                        <div><div class="m-dname">Dr. Boubbou</div><div class="m-dinfo">Médecin généraliste · 150 MAD · Dispo auj.</div></div>
                        <div class="m-chk"></div>
                    </div>
                    <div class="m-doc" onclick="pickDoc(this,'Dr. Martin','Cardiologue','300 MAD','linear-gradient(135deg,#10b981,#047857)')">
                        <div class="m-ava" style="background:linear-gradient(135deg,#10b981,#047857);">MT</div>
                        <div><div class="m-dname">Dr. Martin</div><div class="m-dinfo">Cardiologue · 300 MAD · Dispo demain</div></div>
                        <div class="m-chk"></div>
                    </div>
                    <div class="m-doc" onclick="pickDoc(this,'Dr. Karimi','Endocrinologue','250 MAD','linear-gradient(135deg,#f59e0b,#d97706)')">
                        <div class="m-ava" style="background:linear-gradient(135deg,#f59e0b,#d97706);">KA</div>
                        <div><div class="m-dname">Dr. Karimi</div><div class="m-dinfo">Endocrinologue · 250 MAD · 22 avr.</div></div>
                        <div class="m-chk"></div>
                    </div>
                </div>
                <div class="divider"></div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span class="lbl-sm" style="margin:0;">Date</span>
                    <div class="m-cal-hd" style="gap:8px;margin:0;">
                        <div class="m-cal-btn" onclick="mc(-1)"><i class="bi bi-chevron-left"></i></div>
                        <div class="m-cal-month" id="mcMonth"></div>
                        <div class="m-cal-btn" onclick="mc(1)"><i class="bi bi-chevron-right"></i></div>
                    </div>
                </div>
                <div class="m-grid" id="mcGrid"></div>
                <span class="lbl-sm">Créneau · <span id="slotLbl" style="text-transform:none;letter-spacing:0;font-weight:600;">Sélectionnez une date</span></span>
                <div class="m-slots" id="mSlots">
                    <div style="grid-column:1/-1;text-align:center;color:var(--hint);font-size:12.5px;padding:10px 0;">—</div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="sp" id="sp2">
                <div class="m-recap" id="recapBox"></div>
                <div class="m-row">
                    <div class="m-fg"><label class="m-lbl">Prénom *</label><input class="m-inp" id="iP" placeholder="Votre prénom" oninput="chk()"></div>
                    <div class="m-fg"><label class="m-lbl">Nom *</label><input class="m-inp" id="iN" placeholder="Votre nom"></div>
                </div>
                <div class="m-row">
                    <div class="m-fg"><label class="m-lbl">Téléphone *</label><input class="m-inp" id="iT" type="tel" placeholder="06 XX XX XX XX" oninput="chk()"></div>
                    <div class="m-fg"><label class="m-lbl">Email</label><input class="m-inp" id="iE" type="email" placeholder="email@exemple.com"></div>
                </div>
                <div class="m-fg"><label class="m-lbl">Motif *</label>
                    <select class="m-sel" id="iM" onchange="chk()">
                        <option value="">Sélectionner…</option>
                        <option>Première consultation</option><option>Suivi maladie chronique</option>
                        <option>Renouvellement ordonnance</option><option>Fièvre / Infection</option>
                        <option>Résultats d'analyses</option><option>Vaccination</option><option>Autre</option>
                    </select>
                </div>
                <div class="m-fg"><label class="m-lbl">Notes <span style="color:var(--hint);font-weight:500;">(optionnel)</span></label><textarea class="m-ta" id="iNo" placeholder="Symptômes, précisions…"></textarea></div>
            </div>

            <!-- STEP 3 SUCCESS -->
            <div class="sp" id="sp3">
                <div class="suc-box">
                    <div class="suc-ico"><i class="bi bi-check-lg"></i></div>
                    <div class="suc-title">RDV confirmé !</div>
                    <div class="suc-sub">Vous recevrez un SMS de confirmation. Un rappel vous sera envoyé 24h avant.</div>
                    <div class="m-recap" id="recapFinal"></div>
                </div>
            </div>

        </div>
        <div class="modal-ft" id="mFt">
            <button class="m-btn-back" id="bBack" onclick="prev()" style="display:none;"><i class="bi bi-arrow-left"></i> Retour</button>
            <button class="m-btn-next" id="bNext" onclick="next()" disabled><i class="bi bi-arrow-right"></i> Continuer</button>
        </div>
    </div>
</div>





<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
