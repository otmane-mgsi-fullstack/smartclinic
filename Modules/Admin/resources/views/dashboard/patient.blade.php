
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- CSS ici -->
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">

</head>



@extends('admin::dashboard.layout')

<body>
@section('content')

    <div class="card">

        <div class="card-header">
            <h3><i class="bi bi-people"></i> Gestion des patients</h3>

            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                <i class="bi bi-plus-lg"></i> Ajouter
            </button>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- TABLE -->
        <table class="custom-table table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>CIN</th>
                <th>Date naissance</th>
                <th>Adresse</th>
            </tr>
            </thead>

            <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->user->name }}</td>
                    <td>{{ $patient->user->email }}</td>
                    <td>{{ $patient->cin }}</td>
                    <td>{{ $patient->date_naissance }}</td>
                    <td>{{ $patient->adresse }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>


    <!-- MODAL -->
    <div class="modal fade" id="addPatientModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content custom-modal">

                <div class="modal-header">
                    <h5><i class="bi bi-person-plus"></i> Nouveau patient</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                    <form action="{{ route('admin.patient.store') }}" method="POST">
                        @csrf
                    <div class="modal-body">

                        <div class="form-grid">

                            <input type="text" name="nom" placeholder="Nom" required>
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="password" name="password" placeholder="Mot de passe" required>

                            <input type="text" name="cin" placeholder="CIN">
                            <input type="date" name="date_naissance">
                            <input type="text" name="adresse" placeholder="Adresse">

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-save">Enregistrer</button>
                    </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                </form>

            </div>
        </div>
    </div>

@endsection



<style>


    /* CARD */
    .card-modern {
        background: linear-gradient(135deg, #ffffff, #f1f5f9);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .card-modern:hover {
        transform: translateY(-5px);
    }

    /* HEADER */
    .card-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header-modern h3 {
        font-weight: 600;
        color: #1e293b;
    }

    .card-header-modern i {
        color: #6366f1;
    }

    /* BUTTON */
    .btn-add {
        background: linear-gradient(135deg, #6366f1, #3b82f6);
        color: white;
        padding: 10px 16px;
        border-radius: 10px;
        border: none;
        transition: 0.3s;
    }

    .btn-add:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(99,102,241,0.4);
    }

    /* TABLE */
    .table-modern {
        border-radius: 10px;
        overflow: hidden;
    }

    .table-modern tbody tr {
        transition: 0.2s;
    }

    .table-modern tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }

    /* ALERT */
    .alert-modern {
        background: #dcfce7;
        color: #166534;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    /* FORM */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-grid input {
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    /* MODAL */
    .modal-modern {
        border-radius: 20px;
        padding: 10px;
        backdrop-filter: blur(10px);
    }

    /* BUTTONS */
    .btn-save {
        background: #22c55e;
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        border: none;
    }

    .btn-cancel {
        background: #e5e7eb;
        padding: 8px 14px;
        border-radius: 8px;
        border: none;
    }

</style>




<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
