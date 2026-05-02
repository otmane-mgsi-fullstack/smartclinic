<?php

namespace Modules\Medecin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Medecin\App\Models\Disponibilite;
use Illuminate\Validation\Rule;

class DisponibiliteController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request)
    {
        $medecin = auth()->user()->medecin;

        if (!$medecin) {
            abort(403, 'Aucun profil médecin trouvé');
        }

        //  Query de base
        $query = Disponibilite::where('medecin_id', $medecin->id);

        //  Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        //  Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Résultat FINAL (important !)
        $disponibilites = $query
            ->orderBy('date', 'desc')
            ->orderBy('heure_debut', 'desc')
            ->paginate(8)
            ->withQueryString(); // garde le filtre dans pagination

        //  Stats (sur les résultats filtrés)
        $stats = [
            'disponible' => $disponibilites->where('statut', 'disponible')->count(),
            'reserve' => $disponibilites->where('statut', 'reserve')->count(),
            'indisponible' => $disponibilites->where('statut', 'indisponible')->count(),
            'total' => $disponibilites->total(), // important (pagination)
        ];

        return view('medecin::dashboard.disponibilite', compact('disponibilites', 'stats'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {


        // 1. Validation

        $request->validate([
            'date' => 'required|date',
            'heure_debut' => [
                'required',
                Rule::unique('disponibilites')
                    ->where(function ($query) use ($request) {
                        return $query->where('date', $request->date)
                            ->where('medecin_id', auth()->user()->medecin->id);
                    })
            ],
            'heure_fin' => 'required|after:heure_debut',
            'statut' => 'required|in:disponible,reserve,indisponible',
        ]);


        $medecin = auth()->user()->medecin;

        // 2. Création
        $disponibilite = new Disponibilite();
        $disponibilite->date = $request->date;
        $disponibilite->heure_debut = $request->heure_debut;
        $disponibilite->heure_fin = $request->heure_fin;
        $disponibilite->statut = $request->statut;
        //$disponibilite->medecin_id = auth()->user()->id;
        // (optionnel si lié au médecin connecté)
        // $disponibilite->medecin_id = auth()->id();
        $disponibilite->medecin_id = $medecin->id;

        // 3. Sauvegarde
        $disponibilite->save();

        // 4. Réponse
        return redirect()->back()->with('success', 'Créneau ajouté avec succès');
    }


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
