<?php
namespace Modules\Rdv\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Rdv\App\Models\RendezVous;
use Modules\Medecin\App\Models\Disponibilite;

class RdvBookingController extends Controller
{

    public function store(Request $request)
    {
        // Affiche tout ce qui arrive du formulaire
        // Si cela ne s'affiche pas, le problème est avant le contrôleur (Route/Middleware)
        // dd($request->all());
        $user = auth()->user();

        $request->validate([
            'disponibilite_id' => 'required|exists:disponibilites,id',
            'motif' => 'required|string|max:255',
        ]);

        if (!$user->patient) {
            return redirect()->back()->with('error', "Action impossible : Votre compte n'est pas configuré comme un profil Patient.");
        }


        // Test d'insertion directe sans transaction pour voir l'erreur SQL
        $dispo = Disponibilite::findOrFail($request->disponibilite_id);

        // Vérifiez si le patient existe bien pour l'utilisateur connecté
        $patient = auth()->user()->patient;
        if(!$patient) {
            dd("L'utilisateur connecté n'a pas de profil Patient lié.");
        }

        $rdv = RendezVous::create([
            'date_heure'       => $dispo->date . ' ' . $dispo->heure_debut,
            'statut'           => 'planifie',
            'motif'            => $request->motif,
            'patient_id'       => $patient->id,
            'medecin_id'       => $dispo->medecin_id,
            'disponibilite_id' => $dispo->id,
        ]);

        $dispo->update(['statut' => 'reserve']);

        dd("Insertion réussie !", $rdv);
    }

}
