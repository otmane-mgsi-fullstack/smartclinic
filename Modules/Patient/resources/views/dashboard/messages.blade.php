@extends('patient::dashboard.layout')

@section('content')
    <style>
        .chat-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: calc(100vh - 240px);
            min-height: 480px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--sh);
            overflow: hidden;
        }

        /* ── Sidebar contacts ── */
        .chat-sidebar {
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            background: var(--bg);
        }
        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }
        .sidebar-header h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }
        .contact-list {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 10px;
            gap: 6px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s;
            background: var(--surface);
            border: 1px solid transparent;
        }
        .contact-item:hover {
            background: var(--blue-lt);
            border-color: var(--blue-md);
        }
        .contact-item.active {
            background: var(--blue-lt);
            border-color: var(--blue);
            font-weight: 500;
        }
        .contact-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--blue-md);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 13px;
            position: relative;
        }
        .status-dot {
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #94a3b8;
            border: 1.5px solid #fff;
        }
        .status-dot.online {
            background: var(--green);
        }

        /* ── Chat Window ── */
        .chat-window {
            display: flex;
            flex-direction: column;
            background: var(--surface);
        }
        .chat-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
            background: #f8fafc;
        }
        .chat-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
        }

        /* ── Messages bubble ── */
        .msg-bubble {
            max-width: 70%;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 13.5px;
            line-height: 1.5;
            animation: fadeIn .2s ease both;
        }
        .msg-bubble.sent {
            background: var(--blue);
            color: #fff;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }
        .msg-bubble.received {
            background: #e2e8f0;
            color: var(--text);
            align-self: flex-start;
            border-bottom-left-radius: 2px;
        }
        .msg-meta {
            font-size: 10px;
            color: var(--hint);
            margin-top: 4px;
            text-align: right;
        }
        .msg-bubble.received .msg-meta {
            color: var(--muted);
        }

        /* ── Input bar ── */
        .input-bar {
            display: flex;
            gap: 10px;
        }
        .input-bar input {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13.5px;
            background: var(--bg);
        }
        .input-bar input:focus {
            outline: none;
            border-color: var(--blue);
            background: #fff;
        }
        .input-bar button {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .15s;
        }
        .input-bar button:hover {
            opacity: .9;
        }

        /* ── Typing Indicator ── */
        .typing-indicator {
            display: none;
            align-self: flex-start;
            background: #e2e8f0;
            padding: 10px 14px;
            border-radius: 12px;
            border-bottom-left-radius: 2px;
            align-items: center;
            gap: 4px;
        }
        .typing-dot {
            width: 6px;
            height: 6px;
            background: #64748b;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1.0); }
        }
    </style>

    <div class="chat-container">
        <!-- Sidebar Contacts -->
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <h3>Mes Professionnels</h3>
            </div>
            <div class="contact-list">
                <div class="contact-item active" onclick="selectDoctor('Dr. Jean Boubbou', 'JB', 'Médecin Généraliste')">
                    <div class="contact-avatar" style="background: var(--blue);">
                        JB
                        <div class="status-dot online"></div>
                    </div>
                    <div>
                        <div style="font-size: 13.5px; font-weight: 600; color: var(--text);">Dr. Jean Boubbou</div>
                        <span style="font-size: 11px; color: var(--muted);">Médecin Généraliste</span>
                    </div>
                </div>
                <div class="contact-item" onclick="selectDoctor('Dr. Karim Mansouri', 'KM', 'Diabétologue')">
                    <div class="contact-avatar" style="background: var(--green);">
                        KM
                        <div class="status-dot"></div>
                    </div>
                    <div>
                        <div style="font-size: 13.5px; font-weight: 600; color: var(--text);">Dr. Karim Mansouri</div>
                        <span style="font-size: 11px; color: var(--muted);">Diabétologue</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Window -->
        <div class="chat-window">
            <div class="chat-header">
                <div>
                    <h4 id="active-doctor-name" style="font-size: 15px; font-weight: 600; color: var(--text); margin: 0;">Dr. Jean Boubbou</h4>
                    <span id="active-doctor-spec" style="font-size: 11px; color: var(--muted);">Médecin Généraliste</span>
                </div>
                <span class="badge badge-green" style="font-size: 10px;">En ligne</span>
            </div>

            <!-- Messages Stream -->
            <div class="chat-body" id="chat-stream">
                <!-- Initial messages thread -->
                <div class="msg-bubble received">
                    Bonjour, j'ai bien reçu vos résultats de bilan sanguin. Les indicateurs de fer sont un peu bas.
                    <div class="msg-meta">Hier, 14:32</div>
                </div>
                <div class="msg-bubble sent">
                    D'accord Docteur, que dois-je faire ? Est-ce que je dois prendre des suppléments ?
                    <div class="msg-meta">Hier, 14:40</div>
                </div>
                <div class="msg-bubble received">
                    Oui, je vous ai partagé une ordonnance de Tardyferon dans votre espace documents. Prenez-en un par jour pendant un mois.
                    <div class="msg-meta">Hier, 14:45</div>
                </div>
                
                <!-- Typing Indicator -->
                <div class="typing-indicator" id="typing-indicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>

            <!-- Message Footer Input -->
            <div class="chat-footer">
                <form id="message-form" class="input-bar" onsubmit="sendMessage(event)">
                    <input type="text" id="message-input" placeholder="Écrivez votre message ici..." required autocomplete="off">
                    <button type="submit">
                        Envoyer <i class="bi bi-send-fill" style="margin-left: 4px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Select contacts
        function selectDoctor(name, initials, spec) {
            document.getElementById('active-doctor-name').textContent = name;
            document.getElementById('active-doctor-spec').textContent = spec;
            document.querySelectorAll('.contact-item').forEach(c => c.classList.remove('active'));
            event.currentTarget.classList.add('active');
            
            // Clean and load custom thread based on name
            const stream = document.getElementById('chat-stream');
            const typing = document.getElementById('typing-indicator');
            
            // Remove previous messages
            const bubbles = stream.querySelectorAll('.msg-bubble');
            bubbles.forEach(b => b.remove());
            
            // Insert specific mock thread
            if (name.includes('Boubbou')) {
                insertMessage('Bonjour, j\'ai bien reçu vos résultats de bilan sanguin. Les indicateurs de fer sont un peu bas.', 'received', 'Hier, 14:32');
                insertMessage('D\'accord Docteur, que dois-je faire ? Est-ce que je dois prendre des suppléments ?', 'sent', 'Hier, 14:40');
                insertMessage('Oui, je vous ai partagé une ordonnance de Tardyferon dans votre espace documents. Prenez-en un par jour pendant un mois.', 'received', 'Hier, 14:45');
            } else {
                insertMessage('Bonjour Youssef, comment se déroule votre traitement de diabète ?', 'received', 'Mardi dernier, 10:15');
                insertMessage('Bonjour Docteur, ma glycémie à jeun s\'est stabilisée autour de 1.10.', 'sent', 'Mardi dernier, 10:20');
                insertMessage('C\'est parfait. Continuez le Glucophage comme prescrit et n\'oubliez pas de surveiller votre alimentation.', 'received', 'Mardi dernier, 10:25');
            }
            
            // Scroll to bottom
            stream.appendChild(typing);
            stream.scrollTop = stream.scrollHeight;
        }

        function insertMessage(text, type, timeStr) {
            const stream = document.getElementById('chat-stream');
            const bubble = document.createElement('div');
            bubble.className = `msg-bubble ${type}`;
            bubble.innerHTML = `${text}<div class="msg-meta">${timeStr}</div>`;
            stream.appendChild(bubble);
        }

        // Send a message
        function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const text = input.value.trim();
            if (!text) return;

            // Append user message
            const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            insertMessage(text, 'sent', `Aujourd'hui, ${timeNow}`);
            input.value = '';

            // Scroll to bottom
            const stream = document.getElementById('chat-stream');
            const typing = document.getElementById('typing-indicator');
            stream.appendChild(typing); // keep typing indicator at bottom
            stream.scrollTop = stream.scrollHeight;

            // Trigger mock doctor reply
            simulateDoctorReply(text);
        }

        // Mock reply logic
        function simulateDoctorReply(userText) {
            const typing = document.getElementById('typing-indicator');
            const stream = document.getElementById('chat-stream');
            
            // Show typing indicator after 800ms
            setTimeout(() => {
                typing.style.display = 'flex';
                stream.scrollTop = stream.scrollHeight;
            }, 800);

            // Hide typing and append reply after 2.5s
            setTimeout(() => {
                typing.style.display = 'none';
                
                // Determine mock response text
                let replyText = "Bien reçu. Je reviens vers vous dès que possible.";
                const lowerText = userText.toLowerCase();
                
                if (lowerText.includes('bonjour') || lowerText.includes('salut')) {
                    replyText = "Bonjour ! Comment allez-vous aujourd'hui ? Avez-vous des questions sur votre traitement ?";
                } else if (lowerText.includes('ordonnance') || lowerText.includes('médicament')) {
                    replyText = "Toutes vos ordonnances actives sont téléchargeables depuis votre espace 'Mes Documents'. En cas de problème de tolérance, contactez-moi.";
                } else if (lowerText.includes('rdv') || lowerText.includes('rendez-vous') || lowerText.includes('créneau')) {
                    replyText = "Pour prendre ou déplacer un rendez-vous, vous pouvez utiliser la page 'Prendre RDV' ou consulter mes 'Disponibilités'.";
                } else if (lowerText.includes('merci') || lowerText.includes('d\'accord')) {
                    replyText = "Je vous en prie. Prenez soin de vous !";
                }

                const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                insertMessage(replyText, 'received', `Aujourd'hui, ${timeNow}`);
                stream.scrollTop = stream.scrollHeight;
            }, 2500);
        }

        // Initial scroll to bottom
        window.onload = function() {
            const stream = document.getElementById('chat-stream');
            stream.scrollTop = stream.scrollHeight;
        }
    </script>
@endsection
