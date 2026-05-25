@extends('medecin::dashboard.layout')

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h1 style="color: var(--text); font-size: 24px; font-weight: 700; margin: 0;">Modifier Patient</h1>
                <p style="color: var(--muted); margin: 4px 0 0;">Mettez à jour les informations de {{ $patient->user->name }}.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('medecin.patients.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 600;">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="card" style="background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 30px; box-shadow: var(--sh); max-width: 800px; margin: 0 auto;">
            <form action="{{ route('medecin.patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label" style="font-weight: 600; color: var(--text);">Nom Complet <span style="color: var(--red);">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $patient->user->name) }}" class="form-control @error('name') is-invalid @enderror" required style="border-radius: 8px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label" style="font-weight: 600; color: var(--text);">Adresse Email <span style="color: var(--red);">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $patient->user->name ? $patient->user->email : '') }}" class="form-control @error('email') is-invalid @enderror" required style="border-radius: 8px;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cin" class="form-label" style="font-weight: 600; color: var(--text);">CIN <span style="color: var(--red);">*</span></label>
                        <input type="text" name="cin" id="cin" value="{{ old('cin', $patient->cin) }}" class="form-control @error('cin') is-invalid @enderror" required style="border-radius: 8px; text-transform: uppercase;">
                        @error('cin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label" style="font-weight: 600; color: var(--text);">Date de Naissance <span style="color: var(--red);">*</span></label>
                        <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $patient->date_naissance) }}" class="form-control @error('date_naissance') is-invalid @enderror" required style="border-radius: 8px;">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label" style="font-weight: 600; color: var(--text);">Modifier le Mot de Passe</label>
                        <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Laisser vide pour ne pas modifier" style="border-radius: 8px;">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--muted); display: block; margin-top: 4px;">Remplir ce champ uniquement si vous souhaitez forcer un nouveau mot de passe pour le patient.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label" style="font-weight: 600; color: var(--text);">Adresse</label>
                        <textarea name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="2" style="border-radius: 8px;">{{ old('adresse', $patient->adresse) }}</textarea>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr style="border-color: var(--border); margin: 30px 0 20px;">

                <div class="row">
                    <div class="col text-end">
                        <a href="{{ route('medecin.patients.index') }}" class="btn btn-light" style="border-radius: 8px; font-weight: 600; padding: 10px 20px; border: 1px solid var(--border); margin-right: 10px;">
                            Annuler
                        </a>
                        <button type="submit" class="btn" style="background: var(--blue); color: #fff; border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                            <i class="bi bi-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
