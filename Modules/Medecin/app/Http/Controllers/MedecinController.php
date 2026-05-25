<?php

namespace Modules\Medecin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedecinController extends Controller
{
    public function dashboard()
    {
        // 1. Récupérer l'utilisateur avec son profil médecin
        $user = Auth::user()->load('medecin');
        $medecin = $user->medecin;

        if (!$medecin) {
            abort(403, "Vous n'avez pas de profil médecin associé à votre compte.");
        }

        // 2. Calculer les statistiques pour la sidebar et la topbar
        $dateAujourdhui = Carbon::now();
        $dateAffichage = $dateAujourdhui->translatedFormat('l j F Y');

        // Nombre de RDV aujourd'hui
        $nbRdvAujourdhui = $medecin->rendezVous()
            ->whereDate('date_heure', Carbon::today())
            ->count();

        // Nombre total de patients uniques
        $nbTotalPatients = \Modules\Patient\App\Models\Patient::count();

        // Patients vus ce mois-ci
        $nbPatientsCeMois = $medecin->rendezVous()
            ->whereMonth('date_heure', Carbon::now()->month)
            ->whereYear('date_heure', Carbon::now()->year)
            ->distinct('patient_id')
            ->count('patient_id');

        // Total documents (dossiers)
        $nbTotalDocuments = \Modules\Document\App\Models\Document::count();

        // Ordonnances émises par ce médecin
        $nbOrdonnances = \Modules\Ordonnance\App\Models\Ordonnance::whereHas('consultation.rendezVous', function($q) use ($medecin) {
            $q->where('medecin_id', $medecin->id);
        })->count();

        // Liste des RDV d'aujourd'hui
        $rdvsAujourdhui = $medecin->rendezVous()
            ->with('patient.user')
            ->whereDate('date_heure', Carbon::today())
            ->orderBy('date_heure', 'asc')
            ->get();

        // Liste des documents récents
        $documentsRecents = \Modules\Document\App\Models\Document::with('patient.user')
            ->latest()
            ->take(5)
            ->get();

        // 3. Envoyer le tout à la vue
        return view('medecin::dashboard.index', [
            'user' => $user,
            'medecin' => $medecin,
            'nbRdvAujourdhui' => $nbRdvAujourdhui,
            'nbTotalPatients' => $nbTotalPatients,
            'nbPatientsCeMois' => $nbPatientsCeMois,
            'nbTotalDocuments' => $nbTotalDocuments,
            'nbOrdonnances' => $nbOrdonnances,
            'rdvsAujourdhui' => $rdvsAujourdhui,
            'documentsRecents' => $documentsRecents,
            'dateAffichage' => $dateAffichage
        ]);
    }
}
