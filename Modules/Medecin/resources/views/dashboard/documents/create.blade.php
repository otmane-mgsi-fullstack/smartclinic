@extends('medecin::dashboard.layout')

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h1 style="color: var(--text); font-size: 24px; font-weight: 700; margin: 0;">Ajouter un Document</h1>
                <p style="color: var(--muted); margin: 4px 0 0;">Téléversez un fichier médical (analyse, radio, ordonnance...) et liez-le au dossier d'un patient.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('medecin.documents.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 600;">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="card" style="background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 30px; box-shadow: var(--sh); max-width: 600px; margin: 0 auto;">
            <form action="{{ route('medecin.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Sélection du patient -->
                <div class="mb-4">
                    <label for="patient_id" class="form-label" style="font-weight: 600; color: var(--text);">Sélectionner le Patient <span style="color: var(--red);">*</span></label>
                    <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required style="border-radius: 8px;">
                        <option value="">-- Choisir un patient dans la liste --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ (old('patient_id') ?? $preselectedPatientId) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} (CIN: {{ $patient->cin }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type de document -->
                <div class="mb-4">
                    <label for="type_document" class="form-label" style="font-weight: 600; color: var(--text);">Type de Document <span style="color: var(--red);">*</span></label>
                    <select name="type_document" id="type_document" class="form-select @error('type_document') is-invalid @enderror" required style="border-radius: 8px;">
                        <option value="">-- Sélectionner le type --</option>
                        <option value="ordonnance" {{ old('type_document') == 'ordonnance' ? 'selected' : '' }}>Ordonnance</option>
                        <option value="analyse" {{ old('type_document') == 'analyse' ? 'selected' : '' }}>Rapport d'Analyse</option>
                        <option value="radio" {{ old('type_document') == 'radio' ? 'selected' : '' }}>Radiographie / Imagerie</option>
                        <option value="autre" {{ old('type_document') == 'autre' ? 'selected' : '' }}>Autre document</option>
                    </select>
                    @error('type_document')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fichier -->
                <div class="mb-4">
                    <label for="file" class="form-label" style="font-weight: 600; color: var(--text);">Fichier à téléverser <span style="color: var(--red);">*</span></label>
                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required style="border-radius: 8px;">
                    <small style="color: var(--muted); display: block; margin-top: 6px;">
                        Formats recommandés : PDF, JPG, PNG. Taille maximum autorisée : 10 Mo.
                    </small>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr style="border-color: var(--border); margin: 30px 0 20px;">

                <div class="text-end">
                    <a href="{{ route('medecin.documents.index', ['patient_id' => $preselectedPatientId]) }}" class="btn btn-light" style="border-radius: 8px; font-weight: 600; padding: 10px 20px; border: 1px solid var(--border); margin-right: 10px;">
                        Annuler
                    </a>
                    <button type="submit" class="btn" style="background: var(--blue); color: #fff; border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="bi bi-upload"></i> Téléverser le Document
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
