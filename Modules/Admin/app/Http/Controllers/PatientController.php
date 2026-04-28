<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Modules\Patient\App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->latest()->get();

        return view('admin::dashboard.patient', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
        ]);

        DB::beginTransaction();

        try {

            // USER
            $user = User::create([
                'name' => $request->nom,
                'email' => $request->email,
                'role' => 'patient',
                'password' => Hash::make($request->password),
            ]);

            // PATIENT
            Patient::create([
                'cin' => $request->cin,
                'date_naissance' => $request->date_naissance,
                'adresse' => $request->adresse,
                'user_id' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('admin.patient.index')
                ->with('success', 'Patient ajouté');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage()); // 🔥 pour voir l'erreur réelle
        }
    }
}
