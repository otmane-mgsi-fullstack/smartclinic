<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Modules\Medecin\App\Models\Medecin;
use App\Models\User;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $medecins = Medecin::with('user')->get(); // 🔥 important

        return view('admin::dashboard.medecin', compact('medecins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // 1️ créer le user
        $user = User::create([
            'name' => $request->nom,
            'email' => $request->email,
            'role' => 'medecin',
            'password' => Hash::make($request->password)
        ]);

        // 2️ créer le medecin lié
        Medecin::create([
            'specialite' => $request->specialite,
            'tarif_consultation' => $request->tarif,
            'biographie' => $request->biographie,
            'user_id' => $user->id, // 🔥 liaison ici
        ]);

        return redirect()->route('admin.medecin.index')
            ->with('success', 'Médecin ajouté');    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
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
