@extends('medecin::dashboard.layout')

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h1 style="color: var(--text); font-size: 24px; font-weight: 700; margin: 0;">Nouveau Patient</h1>
                <p style="color: var(--muted); margin: 4px 0 0;">Enregistrez un nouveau patient et créez-lui un compte d'accès.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('medecin.patients.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 600;">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="card" style="background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 30px; box-shadow: var(--sh); max-width: 800px; margin: 0 auto;">
            <form action="{{ route('medecin.patients.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label" style="font-weight: 600; color: var(--text);">Nom Complet <span style="color: var(--red);">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ex: Jean Dupont" required style="border-radius: 8px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label" style="font-weight: 600; color: var(--text);">Adresse Email <span style="color: var(--red);">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Ex: jean.dupont@email.com" required style="border-radius: 8px;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cin" class="form-label" style="font-weight: 600; color: var(--text);">CIN <span style="color: var(--red);">*</span></label>
                        <input type="text" name="cin" id="cin" value="{{ old('cin') }}" class="form-control @error('cin') is-invalid @enderror" placeholder="Ex: AB12345" required style="border-radius: 8px; text-transform: uppercase;">
                        @error('cin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label" style="font-weight: 600; color: var(--text);">Date de Naissance <span style="color: var(--red);">*</span></label>
                        <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" class="form-control @error('date_naissance') is-invalid @enderror" required style="border-radius: 8px;">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label" style="font-weight: 600; color: var(--text);">Mot de Passe Temporaire <span style="color: var(--red);">*</span></label>
                        <div class="input-group">
                            <input type="text" name="password" id="password" value="{{ old('password', Str::random(8)) }}" class="form-control @error('password') is-invalid @enderror" required style="border-radius: 8px 0 0 8px;">
                            <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()" style="border-radius: 0 8px 8px 0;">
                                <i class="bi bi-arrow-clockwise"></i> Générer
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small style="color: var(--muted); display: block; margin-top: 4px;">Ce mot de passe permettra au patient de se connecter à son propre espace.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label" style="font-weight: 600; color: var(--text);">Adresse</label>
                        <textarea name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="2" placeholder="Adresse complète du patient..." style="border-radius: 8px;">{{ old('adresse') }}</textarea>
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
                            <i class="bi bi-save"></i> Enregistrer le Patient
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function generatePassword() {
            const length = 8;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
            let retVal = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("password").value = retVal;
        }
    </script>
@endsection
