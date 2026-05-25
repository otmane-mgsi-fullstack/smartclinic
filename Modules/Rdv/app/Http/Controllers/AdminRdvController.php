<?php

namespace Modules\Rdv\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Rdv\App\Models\RendezVous;
use Modules\Patient\App\Models\Patient;
use Modules\Medecin\App\Models\Medecin;
use Modules\Medecin\App\Models\Disponibilite;

class AdminRdvController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        $appointments = RendezVous::with(['patient.user', 'medecin.user', 'disponibilite'])->latest()->get();
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();
        $availabilities = Disponibilite::where('statut', 'disponible')->with('medecin.user')->latest()->get();

        return view('rdv::admin.index', compact('appointments', 'patients', 'medecins', 'availabilities'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'disponibilite_id' => 'required|exists:disponibilites,id',
            'motif' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $dispo = Disponibilite::findOrFail($request->disponibilite_id);

            // Verify slot is still available
            if ($dispo->statut !== 'disponible') {
                return redirect()->back()->with('error', "Ce créneau n'est plus disponible.");
            }

            // Create appointment
            $rdv = RendezVous::create([
                'date_heure' => $dispo->date . ' ' . $dispo->heure_debut,
                'statut' => 'planifie',
                'motif' => $request->motif,
                'notes' => $request->notes,
                'patient_id' => $request->patient_id,
                'medecin_id' => $dispo->medecin_id,
                'disponibilite_id' => $dispo->id,
            ]);

            // Update slot to reserved
            $dispo->update(['statut' => 'reserve']);

            DB::commit();
            return redirect()->route('admin.rdv.index')->with('success', "Rendez-vous planifié avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Erreur lors de la planification: " . $e->getMessage());
        }
    }

    /**
     * Update the status or notes of an appointment.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:planifie,annule,termine',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $rdv = RendezVous::findOrFail($id);
            $oldStatus = $rdv->statut;
            $newStatus = $request->statut;

            $rdv->update([
                'statut' => $newStatus,
                'notes' => $request->notes,
            ]);

            // Release or lock availability slot based on status change
            if ($newStatus === 'annule' && $oldStatus !== 'annule') {
                if ($rdv->disponibilite) {
                    $rdv->disponibilite->update(['statut' => 'disponible']);
                }
            } elseif ($newStatus !== 'annule' && $oldStatus === 'annule') {
                if ($rdv->disponibilite) {
                    if ($rdv->disponibilite->statut === 'disponible') {
                        $rdv->disponibilite->update(['statut' => 'reserve']);
                    } else {
                        return redirect()->back()->with('error', "Impossible de replanifier : le créneau horaire est déjà occupé par une autre réservation.");
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.rdv.index')->with('success', "Rendez-vous mis à jour avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Erreur lors de la mise à jour: " . $e->getMessage());
        }
    }

    /**
     * Remove the appointment from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $rdv = RendezVous::findOrFail($id);

            // Free slot before deleting appointment
            if ($rdv->disponibilite) {
                $rdv->disponibilite->update(['statut' => 'disponible']);
            }

            $rdv->delete();

            DB::commit();
            return redirect()->route('admin.rdv.index')->with('success', "Rendez-vous supprimé et créneau libéré.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Erreur lors de la suppression: " . $e->getMessage());
        }
    }
}
