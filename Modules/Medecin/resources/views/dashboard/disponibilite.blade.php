@extends('medecin::dashboard.layout')

@section('content')

    <style>
        /* ── DISPO PAGE ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 26px;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 18px;
            box-shadow: var(--sh);
        }
        .stat-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; margin-bottom: 12px;
        }
        .stat-val  { font-size: 24px; font-weight: 800; line-height: 1; margin-bottom: 4px; }
        .stat-lbl  { font-size: 11.5px; color: var(--muted); }

        /* ── GRID ── */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        /* ── CARD ── */
        .dispo-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--sh);
        }
        .dispo-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }
        .dispo-card-title { font-size: 15px; font-weight: 700; color: var(--text); }
        .dispo-card-sub   { font-size: 12px; color: var(--muted); margin-top: 2px; }

        .btn-xs {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12.5px; font-weight: 700;
            padding: 7px 13px; border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent; color: var(--muted);
            cursor: pointer; transition: all 0.15s;
            font-family: 'Nunito', sans-serif;
        }
        .btn-xs:hover { background: var(--surface2); color: var(--text); }
        .btn-xs.primary {
            background: var(--blue); border-color: var(--blue); color: #fff;
        }
        .btn-xs.primary:hover { background: #1e40af; border-color: #1e40af; }
        .btn-xs.success {
            background: var(--green); border-color: var(--green); color: #fff;
        }

        /* ── DAY TABS ── */
        .day-tabs {
            display: flex; gap: 6px;
            padding: 14px 22px;
            border-bottom: 1px solid var(--border);
            overflow-x: auto;
        }
        .day-tab {
            display: flex; flex-direction: column; align-items: center;
            padding: 9px 16px; border-radius: 11px; cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.16s; min-width: 68px; flex-shrink: 0;
        }
        .day-tab:hover { background: var(--surface2); border-color: var(--border); }
        .day-tab.active { background: var(--blue-lt); border-color: var(--blue-md); }
        .day-tab .dn { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; }
        .day-tab .dd { font-size: 20px; font-weight: 800; margin: 3px 0; color: var(--text); }
        .day-tab.active .dd { color: var(--blue); }
        .day-tab .dot { width: 5px; height: 5px; border-radius: 50%; }
        .day-tab.has-s .dot { background: var(--blue); }
        .day-tab.no-s  .dot { background: var(--hint); }
        .day-tab.off-d { opacity: 0.38; pointer-events: none; }

        /* ── SLOTS ── */
        .slots-body   { padding: 20px 22px; }
        .slots-period { margin-bottom: 22px; }
        .period-lbl {
            font-size: 10.5px; font-weight: 800; color: var(--hint);
            text-transform: uppercase; letter-spacing: 0.1em;
            margin-bottom: 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .period-lbl::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        .slot {
            border-radius: 10px; padding: 10px 6px;
            text-align: center; cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s; position: relative;
            user-select: none;
        }
        .slot .st { font-size: 13px; font-weight: 700; display: block; }
        .slot .sd { font-size: 10px; margin-top: 2px; display: block; }

        .slot.available { background: var(--green-lt); border-color: #6ee7b7; color: #065f46; }
        .slot.available:hover { background: #d1fae5; border-color: #34d399; }
        .slot.available .sd { color: var(--green); }

        .slot.booked { background: var(--blue-lt); border-color: var(--blue-md); color: #1e40af; cursor: default; }
        .slot.booked .sd { color: var(--blue); }

        .slot.blocked { background: var(--surface2); border-color: var(--border); color: var(--muted); opacity: 0.65; cursor: pointer; }

        .slot.selected { background: var(--blue); border-color: var(--blue); color: #fff; }
        .slot.selected .sd { color: #bfdbfe; }

        .booked-badge {
            position: absolute; top: 5px; right: 5px;
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--blue);
        }

        /* ── LEGEND ── */
        .legend-row {
            display: flex; gap: 14px; flex-wrap: wrap;
            padding: 12px 22px;
            border-top: 1px solid var(--border);
        }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: 11px; color: var(--muted); }
        .legend-dot  { width: 9px; height: 9px; border-radius: 4px; flex-shrink: 0; }

        /* ── RIGHT PANEL ── */
        .panel-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--sh);
        }
        .panel-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 18px;
            border-bottom: 1px solid var(--border);
            font-size: 14px; font-weight: 700; color: var(--text);
        }
        .panel-body { padding: 14px 18px; }

        /* Toggles */
        .toggle-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
        }
        .toggle-row:last-child { border-bottom: none; }
        .toggle-day-name { font-size: 13px; font-weight: 600; }
        .toggle-info     { font-size: 11px; color: var(--muted); margin-top: 2px; }
        .toggle {
            width: 38px; height: 21px; border-radius: 11px;
            background: var(--border); position: relative;
            cursor: pointer; flex-shrink: 0;
            transition: background 0.2s;
        }
        .toggle.on { background: var(--blue); }
        .toggle::after {
            content: ''; position: absolute;
            width: 15px; height: 15px; border-radius: 50%;
            background: #fff; top: 3px; left: 3px;
            transition: transform 0.2s;
        }
        .toggle.on::after { transform: translateX(17px); }

        /* Breaks */
        .break-item {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 9px; padding: 9px 12px; margin-bottom: 7px;
        }
        .break-time { font-size: 12.5px; font-weight: 700; }
        .break-lbl  { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .remove-btn {
            width: 22px; height: 22px; border-radius: 6px;
            border: 1px solid var(--border); background: transparent;
            cursor: pointer; display: grid; place-items: center;
            color: var(--muted); font-size: 13px;
            transition: all 0.15s; font-family: inherit;
        }
        .remove-btn:hover { background: var(--red-lt); border-color: #fca5a5; color: var(--red); }

        /* Save bar */
        .save-bar {
            display: none;
            align-items: center; justify-content: space-between;
            background: var(--blue-lt);
            border: 1px solid var(--blue-md);
            border-radius: 12px; padding: 12px 16px; margin-top: 16px;
        }
        .save-bar.show { display: flex; }
        .save-bar-txt { font-size: 12.5px; color: var(--blue); font-weight: 600; }

        /* Empty state */
        .empty-day {
            text-align: center; padding: 44px 20px; color: var(--muted);
        }
        .empty-day .ei { font-size: 32px; margin-bottom: 10px; }
        .empty-day .et { font-size: 13.5px; font-weight: 700; color: var(--text); }
        .empty-day .es { font-size: 12px; margin-top: 4px; }

        /* ── MODAL ── */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,0.4); z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 24px 26px; width: 360px;
            box-shadow: var(--sh-md);
        }
        .modal-box h3 { font-size: 16px; font-weight: 800; margin-bottom: 4px; }
        .modal-box p  { font-size: 12.5px; color: var(--muted); margin-bottom: 18px; }
        .modal-box label {
            font-size: 11.5px; font-weight: 700; color: var(--muted);
            display: block; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .modal-box select,
        .modal-box input[type=time] {
            width: 100%;
            border: 1px solid var(--border); border-radius: 9px;
            padding: 9px 12px; font-size: 13px;
            background: var(--surface2); color: var(--text);
            margin-bottom: 14px; font-family: 'Nunito', sans-serif;
            transition: border-color 0.15s;
        }
        .modal-box select:focus,
        .modal-box input[type=time]:focus {
            outline: none; border-color: var(--blue-md);
        }
        .modal-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 4px; }

        /* Responsive */
        @media (max-width: 900px) {
            .content-grid { grid-template-columns: 1fr; }
            .stats-row    { grid-template-columns: repeat(2, 1fr); }
            .slots-grid   { grid-template-columns: repeat(3, 1fr); }
        }
    </style>

    <!-- ── STATS ── -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--blue-lt);">📅</div>
            <div class="stat-val" style="color:var(--blue);" id="s-open">18</div>
            <div class="stat-lbl">Créneaux disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--blue-lt);">👤</div>
            <div class="stat-val" style="color:var(--blue);" id="s-booked">6</div>
            <div class="stat-lbl">Réservés cette semaine</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-lt);">✅</div>
            <div class="stat-val" style="color:var(--green);" id="s-rate">75%</div>
            <div class="stat-lbl">Taux de remplissage</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--amber-lt);">⏱</div>
            <div class="stat-val" style="color:var(--amber);">20 min</div>
            <div class="stat-lbl">Durée par défaut</div>
        </div>
    </div>

    <!-- ── CONTENT GRID ── -->
    <div class="content-grid">

        <!-- LEFT : Semaine -->
        <div class="dispo-card">
            <div class="dispo-card-header">
                <div>
                    <div class="dispo-card-title">Mes créneaux — Semaine du 6 au 12 avril 2026</div>
                    <div class="dispo-card-sub">Cliquez sur un créneau pour le sélectionner / bloquer</div>
                </div>
                <div style="display:flex;gap:8px;">
                    <button class="btn-xs" onclick="showAddModal()">
                        <i class="bi bi-plus-lg"></i> Ajouter
                    </button>
                    <button class="btn-xs primary" id="save-btn" onclick="saveChanges()">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                </div>
            </div>

            <!-- Day tabs -->
            <div class="day-tabs" id="day-tabs"></div>

            <!-- Slots -->
            <div class="slots-body" id="slots-body"></div>

            <!-- Legend -->
            <div class="legend-row">
                <div class="legend-item"><div class="legend-dot" style="background:#6ee7b7;"></div> Disponible</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--blue-md);"></div> Réservé</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--border);"></div> Bloqué</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--blue);"></div> Sélectionné</div>
            </div>
        </div>

        <!-- RIGHT -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Jours de travail -->
            <div class="panel-card">
                <div class="panel-header">
                    <span><i class="bi bi-calendar-week" style="color:var(--blue);margin-right:7px;"></i>Jours de travail</span>
                </div>
                <div class="panel-body" id="toggles-body"></div>
            </div>

            <!-- Pauses -->
            <div class="panel-card">
                <div class="panel-header">
                    <span><i class="bi bi-cup-hot" style="color:var(--teal);margin-right:7px;"></i>Pauses programmées</span>
                    <button class="btn-xs" onclick="showBreakModal()">
                        <i class="bi bi-plus-lg"></i> Ajouter
                    </button>
                </div>
                <div class="panel-body" id="breaks-body"></div>
            </div>

            <!-- Save bar -->
            <div class="save-bar" id="save-bar">
                <div class="save-bar-txt">
                    <i class="bi bi-exclamation-circle" style="margin-right:5px;"></i>
                    <span id="change-count">0</span> modification(s) non enregistrée(s)
                </div>
                <button class="btn-xs primary" onclick="saveChanges()">
                    <i class="bi bi-check-lg"></i> Enregistrer
                </button>
            </div>

        </div>
    </div>

    <!-- ── MODAL : Nouveau créneau ── -->
    <div class="modal-overlay" id="modal-add">
        <div class="modal-box">
            <h3><i class="bi bi-calendar-plus" style="color:var(--blue);margin-right:8px;"></i>Nouveau créneau</h3>
            <p>Ajoutez un créneau à votre planning hebdomadaire</p>
            <label>Jour</label>
            <select id="m-day">
                <option>Lundi 6 avril</option>
                <option>Mardi 7 avril</option>
                <option>Mercredi 8 avril</option>
                <option>Jeudi 9 avril</option>
                <option>Vendredi 10 avril</option>
            </select>
            <label>Heure de début</label>
            <input type="time" id="m-start" value="09:00">
            <label>Durée</label>
            <select id="m-dur">
                <option value="15">15 minutes</option>
                <option value="20" selected>20 minutes</option>
                <option value="30">30 minutes</option>
                <option value="45">45 minutes</option>
                <option value="60">1 heure</option>
            </select>
            <div class="modal-actions">
                <button class="btn-xs" onclick="closeModals()">Annuler</button>
                <button class="btn-xs primary" onclick="addSlot()">
                    <i class="bi bi-plus-lg"></i> Ajouter
                </button>
            </div>
        </div>
    </div>

    <!-- ── MODAL : Pause ── -->
    <div class="modal-overlay" id="modal-break">
        <div class="modal-box">
            <h3><i class="bi bi-cup-hot" style="color:var(--teal);margin-right:8px;"></i>Ajouter une pause</h3>
            <p>Bloquez un intervalle dans votre journée</p>
            <label>Début</label>
            <input type="time" id="b-start" value="12:00">
            <label>Fin</label>
            <input type="time" id="b-end" value="13:30">
            <label>Motif</label>
            <select id="b-reason">
                <option>Pause déjeuner</option>
                <option>Réunion</option>
                <option>Formation</option>
                <option>Personnel</option>
            </select>
            <div class="modal-actions">
                <button class="btn-xs" onclick="closeModals()">Annuler</button>
                <button class="btn-xs primary" onclick="addBreak()">
                    <i class="bi bi-check-lg"></i> Confirmer
                </button>
            </div>
        </div>
    </div>

    <script>
        const DAYS = [
            { name:'Lun', num:'06', active:true,  off:false },
            { name:'Mar', num:'07', active:false, off:false },
            { name:'Mer', num:'08', active:false, off:false },
            { name:'Jeu', num:'09', active:false, off:false },
            { name:'Ven', num:'10', active:false, off:false },
            { name:'Sam', num:'11', active:false, off:true  },
            { name:'Dim', num:'12', active:false, off:true  },
        ];

        const WORK_DAYS = [
            { label:'Lundi',    on:true,  hours:'08:00 – 18:00' },
            { label:'Mardi',    on:true,  hours:'08:00 – 18:00' },
            { label:'Mercredi', on:true,  hours:'08:00 – 18:00' },
            { label:'Jeudi',    on:true,  hours:'08:00 – 18:00' },
            { label:'Vendredi', on:true,  hours:'08:00 – 17:00' },
            { label:'Samedi',   on:false, hours:'Fermé' },
            { label:'Dimanche', on:false, hours:'Fermé' },
        ];

        let breaks = [
            { start:'12:00', end:'13:30', reason:'Pause déjeuner' },
        ];

        let slots = {
            0: [
                {t:'08:00',dur:'20 min',status:'booked'},   {t:'08:20',dur:'20 min',status:'available'},
                {t:'08:40',dur:'20 min',status:'available'}, {t:'09:00',dur:'20 min',status:'booked'},
                {t:'09:20',dur:'20 min',status:'available'}, {t:'09:40',dur:'20 min',status:'available'},
                {t:'10:00',dur:'20 min',status:'available'}, {t:'10:20',dur:'20 min',status:'booked'},
                {t:'10:40',dur:'20 min',status:'available'}, {t:'11:00',dur:'20 min',status:'available'},
                {t:'11:20',dur:'20 min',status:'available'}, {t:'11:40',dur:'20 min',status:'available'},
                {t:'13:30',dur:'20 min',status:'available'}, {t:'13:50',dur:'20 min',status:'available'},
                {t:'14:10',dur:'20 min',status:'booked'},    {t:'14:30',dur:'20 min',status:'available'},
                {t:'14:50',dur:'20 min',status:'available'}, {t:'15:10',dur:'20 min',status:'available'},
            ],
            1: [
                {t:'08:00',dur:'20 min',status:'available'}, {t:'08:20',dur:'20 min',status:'available'},
                {t:'08:40',dur:'20 min',status:'booked'},    {t:'09:00',dur:'20 min',status:'available'},
                {t:'09:20',dur:'20 min',status:'available'}, {t:'09:40',dur:'20 min',status:'booked'},
                {t:'10:00',dur:'20 min',status:'available'}, {t:'10:20',dur:'20 min',status:'available'},
                {t:'13:30',dur:'20 min',status:'available'}, {t:'13:50',dur:'20 min',status:'available'},
            ],
            2: [
                {t:'09:00',dur:'20 min',status:'available'}, {t:'09:20',dur:'20 min',status:'available'},
                {t:'09:40',dur:'20 min',status:'available'}, {t:'10:00',dur:'20 min',status:'booked'},
                {t:'14:00',dur:'20 min',status:'available'}, {t:'14:20',dur:'20 min',status:'available'},
            ],
            3: [
                {t:'08:00',dur:'20 min',status:'available'}, {t:'08:20',dur:'20 min',status:'booked'},
                {t:'09:00',dur:'20 min',status:'available'}, {t:'09:20',dur:'20 min',status:'available'},
                {t:'13:30',dur:'20 min',status:'available'}, {t:'13:50',dur:'20 min',status:'available'},
            ],
            4: [
                {t:'08:00',dur:'20 min',status:'available'}, {t:'08:20',dur:'20 min',status:'available'},
                {t:'08:40',dur:'20 min',status:'booked'},    {t:'09:00',dur:'20 min',status:'available'},
            ],
        };

        let activeDayIdx = 0;
        let selectedSlots = new Set();
        let changes = 0;

        /* ─── RENDER ─── */
        function renderDayTabs() {
            const el = document.getElementById('day-tabs');
            el.innerHTML = DAYS.map((d, i) => {
                const hasS = (slots[i] || []).length > 0;
                return `<div class="day-tab ${d.active ? 'active' : ''} ${d.off ? 'off-d' : ''} ${hasS ? 'has-s' : 'no-s'}"
                     onclick="switchDay(${i})">
            <span class="dn">${d.name}</span>
            <span class="dd">${d.num}</span>
            <div class="dot"></div>
        </div>`;
            }).join('');
        }

        function renderSlots() {
            const daySlots = slots[activeDayIdx] || [];
            const el = document.getElementById('slots-body');

            if (!daySlots.length) {
                el.innerHTML = `<div class="empty-day">
            <div class="ei">📭</div>
            <div class="et">Aucun créneau ce jour</div>
            <div class="es">Activez ce jour ou ajoutez des créneaux</div>
        </div>`;
                return;
            }

            const morning   = daySlots.filter(s => parseInt(s.t) < 12);
            const afternoon = daySlots.filter(s => parseInt(s.t) >= 12);

            function grid(list) {
                return `<div class="slots-grid">${list.map(s => {
                    const key = activeDayIdx + '-' + s.t;
                    const cls = selectedSlots.has(key) ? 'selected' : s.status;
                    return `<div class="slot ${cls}" onclick="toggleSlot('${key}')">
                ${s.status === 'booked' ? '<div class="booked-badge"></div>' : ''}
                <span class="st">${s.t}</span>
                <span class="sd">${s.status === 'booked' ? 'Réservé' : s.dur}</span>
            </div>`;
                }).join('')}</div>`;
            }

            let html = '';
            if (morning.length)   html += `<div class="slots-period"><div class="period-lbl">Matin</div>${grid(morning)}</div>`;
            if (afternoon.length) html += `<div class="slots-period"><div class="period-lbl">Après-midi</div>${grid(afternoon)}</div>`;
            el.innerHTML = html;
        }

        function renderToggles() {
            document.getElementById('toggles-body').innerHTML = WORK_DAYS.map((d, i) => `
        <div class="toggle-row">
            <div>
                <div class="toggle-day-name">${d.label}</div>
                <div class="toggle-info">${d.on ? d.hours : 'Fermé'}</div>
            </div>
            <div class="toggle ${d.on ? 'on' : ''}" onclick="toggleDay(${i})"></div>
        </div>
    `).join('');
        }

        function renderBreaks() {
            const el = document.getElementById('breaks-body');
            if (!breaks.length) {
                el.innerHTML = `<div style="font-size:12px;color:var(--muted);text-align:center;padding:10px 0;">Aucune pause programmée</div>`;
                return;
            }
            el.innerHTML = breaks.map((b, i) => `
        <div class="break-item">
            <div>
                <div class="break-time">${b.start} – ${b.end}</div>
                <div class="break-lbl">${b.reason}</div>
            </div>
            <button class="remove-btn" onclick="removeBreak(${i})">✕</button>
        </div>
    `).join('');
        }

        /* ─── ACTIONS ─── */
        function switchDay(i) {
            DAYS.forEach((d, j) => d.active = j === i);
            activeDayIdx = i;
            selectedSlots.clear();
            renderDayTabs();
            renderSlots();
        }

        function toggleSlot(key) {
            const [di, t] = key.split(/-(.+)/);
            const s = (slots[di] || []).find(x => x.t === t);
            if (!s || s.status === 'booked') return;
            selectedSlots.has(key) ? selectedSlots.delete(key) : selectedSlots.add(key);
            trackChange();
            renderSlots();
        }

        function toggleDay(i) {
            WORK_DAYS[i].on = !WORK_DAYS[i].on;
            trackChange();
            renderToggles();
        }

        function removeBreak(i) {
            breaks.splice(i, 1);
            trackChange();
            renderBreaks();
        }

        function trackChange() {
            changes++;
            document.getElementById('change-count').textContent = changes;
            document.getElementById('save-bar').classList.add('show');
        }

        function saveChanges() {
            changes = 0;
            selectedSlots.clear();
            document.getElementById('save-bar').classList.remove('show');
            const btn = document.getElementById('save-btn');
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Sauvegardé !';
            btn.classList.remove('primary');
            btn.classList.add('success');
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-check-lg"></i> Enregistrer';
                btn.classList.remove('success');
                btn.classList.add('primary');
                renderSlots();
            }, 2000);
        }

        /* ─── MODALS ─── */
        function showAddModal()   { document.getElementById('modal-add').classList.add('show'); }
        function showBreakModal() { document.getElementById('modal-break').classList.add('show'); }
        function closeModals() {
            document.getElementById('modal-add').classList.remove('show');
            document.getElementById('modal-break').classList.remove('show');
        }

        function addSlot() {
            const di  = document.getElementById('m-day').selectedIndex;
            const t   = document.getElementById('m-start').value;
            const dur = document.getElementById('m-dur').value + ' min';
            if (!slots[di]) slots[di] = [];
            slots[di].push({ t, dur, status: 'available' });
            slots[di].sort((a, b) => a.t.localeCompare(b.t));
            closeModals();
            trackChange();
            renderDayTabs();
            renderSlots();
        }

        function addBreak() {
            breaks.push({
                start:  document.getElementById('b-start').value,
                end:    document.getElementById('b-end').value,
                reason: document.getElementById('b-reason').value,
            });
            closeModals();
            trackChange();
            renderBreaks();
        }

        /* Fermer modal en cliquant dehors */
        document.querySelectorAll('.modal-overlay').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) closeModals(); });
        });

        /* ─── INIT ─── */
        renderDayTabs();
        renderSlots();
        renderToggles();
        renderBreaks();
    </script>

@endsection
