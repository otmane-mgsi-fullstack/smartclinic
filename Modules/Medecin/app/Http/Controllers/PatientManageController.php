<?php

namespace Modules\Medecin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Patient\App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PatientManageController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Patient::with('user');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('cin', 'like', "%{$search}%")
                  ->orWhere('adresse', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $patients = $query->latest()->paginate(10)->withQueryString();

        // Statistiques médecin pour layout
        $medecin = Auth::user()->load('medecin')->medecin;
        $nbRdvAujourdhui = $medecin->rendezVous()->whereDate('date_heure', now()->toDateString())->count();
        $nbTotalPatients = Patient::count(); // Tous les patients dans le système

        return view('medecin::dashboard.patients.index', [
            'patients' => $patients,
            'search' => $search,
            'nbRdvAujourdhui' => $nbRdvAujourdhui,
            'nbTotalPatients' => $nbTotalPatients,
        ]);
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        $medecin = Auth::user()->load('medecin')->medecin;
        $nbRdvAujourdhui = $medecin->rendezVous()->whereDate('date_heure', now()->toDateString())->count();
        $nbTotalPatients = Patient::count();

        return view('medecin::dashboard.patients.create', [
            'nbRdvAujourdhui' => $nbRdvAujourdhui,
            'nbTotalPatients' => $nbTotalPatients,
        ]);
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'cin' => 'required|string|max:20|unique:patients,cin',
            'date_naissance' => 'required|date',
            'adresse' => 'nullable|string|max:500',
        ]);

        DB::transaction(function() use ($request) {
            // 1. Création de l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
            ]);

            // 2. Création de la fiche Patient liée
            Patient::create([
                'user_id' => $user->id,
                'cin' => strtoupper($request->cin),
                'date_naissance' => $request->date_naissance,
                'adresse' => $request->adresse,
            ]);
        });

        return redirect()->route('medecin.patients.index')->with('success', 'Le patient a été créé avec succès.');
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        
        $medecin = Auth::user()->load('medecin')->medecin;
        $nbRdvAujourdhui = $medecin->rendezVous()->whereDate('date_heure', now()->toDateString())->count();
        $nbTotalPatients = Patient::count();

        return view('medecin::dashboard.patients.edit', [
            'patient' => $patient,
            'nbRdvAujourdhui' => $nbRdvAujourdhui,
            'nbTotalPatients' => $nbTotalPatients,
        ]);
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'cin' => 'required|string|max:20|unique:patients,cin,' . $patient->id,
            'date_naissance' => 'required|date',
            'adresse' => 'nullable|string|max:500',
        ]);

        DB::transaction(function() use ($request, $user, $patient) {
            // 1. Mise à jour de l'utilisateur
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // 2. Mise à jour de la fiche Patient
            $patient->update([
                'cin' => strtoupper($request->cin),
                'date_naissance' => $request->date_naissance,
                'adresse' => $request->adresse,
            ]);
        });

        return redirect()->route('medecin.patients.index')->with('success', 'Les informations du patient ont été mises à jour.');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        // Grâce à cascadeOnDelete(), supprimer l'utilisateur supprimera aussi le patient
        $user->delete();

        return redirect()->route('medecin.patients.index')->with('success', 'Le patient a été supprimé du système.');
    }
}
