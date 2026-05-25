@extends('admin::dashboard.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
    
    <style>
        /* Badge customizations for our status set */
        .badge.statut-planifie { background: #eff6ff; color: var(--accent); }
        .badge.statut-planifie::before { background: var(--accent); }
        
        .badge.statut-termine { background: #ecfdf5; color: var(--green); }
        .badge.statut-termine::before { background: var(--green); }
        
        .badge.statut-annule { background: #fef2f2; color: var(--red); }
        .badge.statut-annule::before { background: var(--red); }

        /* General styles for buttons */
        .btn-action-icon {
            border: none;
            background: none;
            font-size: 15px;
            padding: 4px 8px;
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-action-edit { color: var(--accent); }
        .btn-action-edit:hover { background: #eff6ff; }
        .btn-action-delete { color: var(--red); }
        .btn-action-delete:hover { background: #fef2f2; }

        .btn-add {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 9px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }
        .btn-add:hover { background: #1d4ed8; }

        /* Custom forms inside modal */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        @media (min-width: 768px) {
            .form-grid { grid-template-columns: 1fr 1fr; }
            .form-grid-full { grid-column: span 2; }
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--muted);
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: inherit;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #93c5fd;
        }

        .alert-custom {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-custom-success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .alert-custom-error {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }
    </style>

    <!-- ALERT FEEDBACKS -->
    @if (session('success'))
        <div class="alert-custom alert-custom-success animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-custom alert-custom-error animate__animated animate__fadeIn">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- KPI GRID -->
    <div class="kpi-grid">
        <div class="kpi-card blue">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Total Rendez-vous</div>
                    <div class="kpi-value">{{ $appointments->count() }}</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-calendar-check"></i></div>
            </div>
            <div class="kpi-trend"><small>Toutes périodes confondues</small></div>
        </div>
        <div class="kpi-card green">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Planifiés</div>
                    <div class="kpi-value">{{ $appointments->where('statut', 'planifie')->count() }}</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-clock-history"></i></div>
            </div>
            <div class="kpi-trend"><small>Consultations à venir</small></div>
        </div>
        <div class="kpi-card amber">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Terminés</div>
                    <div class="kpi-value">{{ $appointments->where('statut', 'termine')->count() }}</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-journal-check"></i></div>
            </div>
            <div class="kpi-trend"><small>Consultations honorées</small></div>
        </div>
        <div class="kpi-card red">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Annulés</div>
                    <div class="kpi-value">{{ $appointments->where('statut', 'annule')->count() }}</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-x-circle"></i></div>
            </div>
            <div class="kpi-trend"><small>Rendez-vous annulés</small></div>
        </div>
    </div>

    <!-- MAIN APPOINTMENTS TABLE -->
    <div class="card animate__animated animate__fadeIn" style="margin-bottom: 30px;">
        <div class="card-header" style="border-bottom: none; margin-bottom: 20px;">
            <div>
                <h3 class="card-title" style="font-size: 18px; font-weight: 600;"><i class="bi bi-calendar-range"></i> Gestion des Rendez-vous</h3>
                <div class="card-sub">Liste complète des réservations et consultations programmées</div>
            </div>
            <!-- ADD BUTTON -->
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addRdvModal">
                <i class="bi bi-plus-lg"></i> Planifier un RDV
            </button>
        </div>

        <div class="table-wrap">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Date & Heure</th>
                        <th>Motif</th>
                        <th>Notes Administrateur</th>
                        <th>Statut</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $rdv)
                        <tr>
                            <td><strong>#{{ $rdv->id }}</strong></td>
                            
                            <!-- Patient Details -->
                            <td>
                                <div class="patient-cell">
                                    <div class="p-avatar" style="background:#eff6ff; color:#2563eb;">
                                        {{ strtoupper(substr($rdv->patient->user->name ?? 'P', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $rdv->patient->user->name ?? 'Inconnu' }}</div>
                                        <div style="font-size: 11px; color: var(--muted);">CIN: {{ $rdv->patient->cin ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Doctor Details -->
                            <td>
                                <div style="font-weight: 500;">Dr. {{ $rdv->medecin->user->name ?? 'Inconnu' }}</div>
                                <div style="font-size: 11px; color: var(--muted);">{{ $rdv->medecin->specialite ?? 'Généraliste' }}</div>
                            </td>
                            
                            <!-- Date & Time -->
                            <td>
                                <div><i class="bi bi-calendar3" style="color: var(--accent); margin-right: 4px;"></i> {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y') }}</div>
                                <div style="font-size: 12px; color: var(--muted); margin-top: 2px;"><i class="bi bi-clock" style="margin-right: 4px;"></i> {{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</div>
                            </td>
                            
                            <!-- Motif -->
                            <td style="max-width: 150px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                {{ $rdv->motif ?? 'Aucun motif renseigné' }}
                            </td>
                            
                            <!-- Notes -->
                            <td style="font-style: italic; color: var(--muted); font-size: 12.5px;">
                                {{ $rdv->notes ? Str::limit($rdv->notes, 40) : '—' }}
                            </td>
                            
                            <!-- Status -->
                            <td>
                                <span class="badge statut-{{ $rdv->statut }}">
                                    @if($rdv->statut === 'planifie')
                                        Planifié
                                    @elseif($rdv->statut === 'termine')
                                        Terminé
                                    @elseif($rdv->statut === 'annule')
                                        Annulé
                                    @else
                                        {{ ucfirst($rdv->statut) }}
                                    @endif
                                </span>
                            </td>
                            
                            <!-- Actions -->
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <!-- Edit Trigger -->
                                    <button class="btn-action-icon btn-action-edit btn-edit-trigger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editRdvModal"
                                            data-id="{{ $rdv->id }}"
                                            data-statut="{{ $rdv->statut }}"
                                            data-notes="{{ $rdv->notes }}"
                                            title="Modifier le statut ou ajouter des notes">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <!-- Delete Trigger -->
                                    <form action="{{ route('admin.rdv.destroy', $rdv->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ? Le créneau horaire associé sera libéré.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon btn-action-delete" title="Supprimer le rendez-vous">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x" style="font-size: 40px; display: block; margin-bottom: 10px; color: var(--border);"></i>
                                Aucun rendez-vous trouvé dans le système.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================= MODAL: ADD APPOINTMENT ================= -->
    <div class="modal fade" id="addRdvModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: var(--shadow);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border); padding: 18px 24px;">
                    <h5 class="modal-title" style="font-weight: 600;"><i class="bi bi-calendar-plus" style="color: var(--accent); margin-right: 8px;"></i> Planifier un nouveau rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.rdv.store') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 24px;">
                        <div class="form-grid">
                            
                            <!-- Select Patient -->
                            <div class="form-group">
                                <label for="patient_id">Sélectionner le Patient</label>
                                <select name="patient_id" id="patient_id" required>
                                    <option value="" disabled selected>-- Choisir un patient --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Inconnu' }} (CIN: {{ $patient->cin }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Availability / Slot -->
                            <div class="form-group">
                                <label for="disponibilite_id">Sélectionner un Créneau Disponible</label>
                                <select name="disponibilite_id" id="disponibilite_id" required>
                                    <option value="" disabled selected>-- Choisir un créneau --</option>
                                    @forelse($availabilities as $dispo)
                                        <option value="{{ $dispo->id }}">
                                            Dr. {{ $dispo->medecin->user->name }} - {{ \Carbon\Carbon::parse($dispo->date)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($dispo->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($dispo->heure_fin)->format('H:i') }})
                                        </option>
                                    @empty
                                        <option value="" disabled>Aucun créneau libre disponible actuellement</option>
                                    @endforelse
                                </select>
                            </div>

                            <!-- Motif -->
                            <div class="form-group form-grid-full">
                                <label for="motif">Motif de consultation</label>
                                <input type="text" name="motif" id="motif" placeholder="Ex: Consultation de routine, Suivi cardiologique..." required>
                            </div>

                            <!-- Admin Notes -->
                            <div class="form-group form-grid-full">
                                <label for="notes">Notes Administrateur (Optionnel)</label>
                                <textarea name="notes" id="notes" rows="3" placeholder="Notes complémentaires (ex: dossier en attente, urgence médicale...)"></textarea>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="modal-footer" style="border-top: 1px solid var(--border); padding: 16px 24px;">
                        <button type="button" class="btn btn-secondary" style="background:#e5e7eb; color:#4b5563; border:none; padding:9px 16px; border-radius:8px; font-weight:500;" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-add">Enregistrer et Planifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ================= MODAL: EDIT STATUS / NOTES ================= -->
    <div class="modal fade" id="editRdvModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: var(--shadow);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border); padding: 18px 24px;">
                    <h5 class="modal-title" style="font-weight: 600;"><i class="bi bi-pencil-square" style="color: var(--accent); margin-right: 8px;"></i> Modifier le rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="editRdvForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-body" style="padding: 24px;">
                        <div class="form-grid" style="grid-template-columns: 1fr;">
                            
                            <!-- Edit Status -->
                            <div class="form-group">
                                <label for="edit_statut">Statut du rendez-vous</label>
                                <select name="statut" id="edit_statut" required>
                                    <option value="planifie">Planifié</option>
                                    <option value="termine">Terminé</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>

                            <!-- Edit Notes -->
                            <div class="form-group">
                                <label for="edit_notes">Notes Administrateur</label>
                                <textarea name="notes" id="edit_notes" rows="4" placeholder="Saisir des notes pour ce rendez-vous..."></textarea>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="modal-footer" style="border-top: 1px solid var(--border); padding: 16px 24px;">
                        <button type="button" class="btn btn-secondary" style="background:#e5e7eb; color:#4b5563; border:none; padding:9px 16px; border-radius:8px; font-weight:500;" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn-add" style="background: var(--green);">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FOR DYNAMIC MODAL BINDING -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editTriggers = document.querySelectorAll('.btn-edit-trigger');
            const editForm = document.getElementById('editRdvForm');
            const editStatut = document.getElementById('edit_statut');
            const editNotes = document.getElementById('edit_notes');

            editTriggers.forEach(trigger => {
                trigger.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const statut = this.getAttribute('data-statut');
                    const notes = this.getAttribute('data-notes');

                    // Set dynamic action URL
                    editForm.action = `{{ url('/admin/rdv') }}/${id}`;

                    // Populate fields
                    editStatut.value = statut;
                    editNotes.value = notes || '';
                });
            });
        });
    </script>
@endsection
