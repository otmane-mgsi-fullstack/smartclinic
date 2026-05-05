<?php
namespace Modules\Medecin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Rdv\App\Models\RendezVous;
use Modules\Medecin\App\Models\Disponibilite;

class RdvManageControlleController extends Controller
{
    public function index()
    {
        // On récupère les RDV du médecin connecté
        $rdvs = RendezVous::with(['patient.user', 'disponibilite'])
            ->where('medecin_id', auth()->user()->medecin->id)
            ->orderBy('date_heure', 'asc')
            ->get();

        return view('medecin::dashboard.rdv', compact('rdvs'));
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Trouver le rendez-vous
        $rdv = RendezVous::findOrFail($id);

        // 2. Mettre à jour le statut du RDV selon la requête
        $rdv->statut = $request->statut;
        $rdv->save();

        // 3. Logique d'interaction avec la disponibilité
        if ($rdv->disponibilite_id) {
            $dispo = Disponibilite::find($rdv->disponibilite_id);

            if ($request->statut === 'annule') {
                // Si annulé, on libère le créneau
                $dispo->statut = 'disponible';
            } else {
                // Pour 'confirme' ou 'termine', il reste 'occupe'
                $dispo->statut = 'occupe';
            }
            $dispo->save();
        }

        return back()->with('success', 'Statut mis à jour avec succès.');
    }
}

