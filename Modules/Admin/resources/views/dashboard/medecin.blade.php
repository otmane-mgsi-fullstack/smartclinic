


@extends('admin::dashboard.layout')

@section('content')

    <!-- HEADER -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-person-badge"></i> Gestion des médecins</h3>

            <!-- BOUTON MODAL -->
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addMedecinModal">
                <i class="bi bi-plus-lg"></i> Ajouter
            </button>
        </div>

        <!-- TABLE -->
        <table class="custom-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Spécialité</th>
                <th>Téléphone</th>
                <th>...</th>
            </tr>
            </thead>

            <tbody>




            @foreach($medecins as $medecin)
                <tr>
                    <td>{{ $medecin->id }}</td>

                    <!--  depuis user -->
                    <td>{{ $medecin->user->name }}</td>
                    <td>{{ $medecin->user->email }}</td>

                    <!-- depuis medecin -->
                    <td>{{ $medecin->specialite }}</td>
                    <td>{{ $medecin->tarif_consultation }}</td>
                    <td>
                        <i class="bi bi-trash-fill"></i>
                        <i class="bi bi-pencil"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <!-- ================= MODAL ================= -->
    <div class="modal fade" id="addMedecinModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content custom-modal">

                <div class="modal-header">
                    <h5><i class="bi bi-person-plus"></i> Nouveau médecin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.medecin.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <div class="form-grid">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="nom" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label>Tarif Consultation</label>
                                <input type="number" name="tarif">
                            </div>

                            <div class="form-group">
                                <label>Spécialité</label>
                                <input type="text" name="specialite">
                            </div>

                            <div class="form-group">
                                <label>Biographie</label>
                                <input type="text" name="biographie">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <button type="submit" class="btn-save">
                            Enregistrer
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


<!-- ================= STYLE ================= -->
<style>
    /* CARD */
    .card {
        background: var(--surface);
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--shadow);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    /* BUTTON */
    .btn-add {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 9px 14px;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-add:hover {
        background: #1d4ed8;
    }

    /* TABLE */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
        background: var(--surface2);
        text-align: left;
        padding: 12px;
    }

    .custom-table td {
        padding: 12px;
        border-top: 1px solid var(--border);
    }

    /* MODAL DESIGN */
    .custom-modal {
        border-radius: 14px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
    }

    .modal-footer {
        border-top: 1px solid var(--border);
    }

    /* FORM */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 12px;
        margin-bottom: 5px;
        color: var(--muted);
    }

    .form-group input {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid var(--border);
    }

    /* BUTTONS */
    .btn-save {
        background: var(--green);
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 8px;
    }

    .btn-cancel {
        background: #e5e7eb;
        border: none;
        padding: 8px 14px;
        border-radius: 8px;
    }
</style>


<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
