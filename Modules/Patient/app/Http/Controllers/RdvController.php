<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Medecin\App\Models\Disponibilite;
use Modules\Medecin\App\Models\Medecin;
use Carbon\Carbon;


class RdvController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request)
    {

            $medecins = Medecin::with('user')->get();

            $query = Disponibilite::with('medecin.user')
                ->where('statut', 'disponible')
                ->whereDate('date', '>=', Carbon::today());

            //  filtre par médecin si sélectionné
            if ($request->medecin_id) {
                $query->where('medecin_id', $request->medecin_id);
            }



                    $selectedMedecin = null;

                    if ($request->medecin_id) {
                        $selectedMedecin = Medecin::with('user')->find($request->medecin_id);
                    }

            //  récupération du créneau sélectionné
                $selectedDispo = null;

                if ($request->dispo) {
                    $selectedDispo = Disponibilite::with('medecin.user')
                        ->find($request->dispo);
                }
             $motif = $request->motif;


            $disponibilites = $query
                ->orderBy('date')
                ->orderBy('heure_debut')
                ->get();

        return view('patient::dashboard.rdv', compact(
            'medecins',
            'disponibilites',
            'selectedDispo',
            'selectedMedecin',
            'motif'
        ));
        }






    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
