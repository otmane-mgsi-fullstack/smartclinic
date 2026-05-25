<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Medecin\App\Models\Disponibilite;
use Modules\Patient\App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Get the patient profile or automatically create one if missing.
     */
    private function getOrCreatePatient($user)
    {
        $patient = $user->patient;

        if (!$patient && $user->role === 'patient') {
            $patient = Patient::create([
                'user_id' => $user->id,
                'cin' => 'TEMP-' . strtoupper(Str::random(6)),
                'date_naissance' => '1990-01-01',
                'adresse' => 'Non renseignée',
            ]);
            $user->load('patient');
        }

        if (!$patient) {
            abort(403, "Profil patient introuvable.");
        }

        return $patient;
    }

    /**
     * Helper to get common layout statistics for the patient.
     */
    private function getLayoutData($patient)
    {
        $prochainRdv = $patient->rendezVous()
            ->with('medecin.user')
            ->where('date_heure', '>=', Carbon::now())
            ->where('statut', 'planifie')
            ->orderBy('date_heure', 'asc')
            ->first();

        $rdvAVenirCount = $patient->rendezVous()
            ->where('date_heure', '>=', Carbon::now())
            ->where('statut', 'planifie')
            ->count();

        $docsCount = $patient->documents()->count();

        return [
            'prochainRdv' => $prochainRdv,
            'rdvAVenirCount' => $rdvAVenirCount,
            'docsCount' => $docsCount,
        ];
    }

    /**
     * Display the patient dashboard index.
     */
    public function index()
    {
        $user = Auth::user();
        $patient = $this->getOrCreatePatient($user);
        $layoutData = $this->getLayoutData($patient);

        // Récupérer les 5 derniers rendez-vous
        $rdvs = $patient->rendezVous()
            ->with('medecin.user')
            ->orderBy('date_heure', 'desc')
            ->take(5)
            ->get();

        // Récupérer les 5 derniers documents
        $documents = $patient->documents()
            ->orderBy('date_upload', 'desc')
            ->take(5)
            ->get();

        return view('patient::dashboard.index', array_merge([
            'user' => $user,
            'patient' => $patient,
            'rdvs' => $rdvs,
            'documents' => $documents,
        ], $layoutData));
    }

    /**
     * Display list of patient appointments.
     */
    public function mesRdvs()
    {
        $user = Auth::user();
        $patient = $this->getOrCreatePatient($user);
        $layoutData = $this->getLayoutData($patient);

        // Récupérer tous les rendez-vous
        $rdvs = $patient->rendezVous()
            ->with('medecin.user')
            ->orderBy('date_heure', 'desc')
            ->get();

        return view('patient::dashboard.mes_rdvs', array_merge([
            'user' => $user,
            'patient' => $patient,
            'rdvs' => $rdvs,
        ], $layoutData));
    }

    /**
     * Display list of patient documents.
     */
    public function documents()
    {
        $user = Auth::user();
        $patient = $this->getOrCreatePatient($user);
        $layoutData = $this->getLayoutData($patient);

        // Récupérer tous les documents
        $documents = $patient->documents()
            ->orderBy('date_upload', 'desc')
            ->get();

        return view('patient::dashboard.documents', array_merge([
            'user' => $user,
            'patient' => $patient,
            'documents' => $documents,
        ], $layoutData));
    }

    /**
     * Download the specified document for the authenticated patient securely.
     */
    public function downloadDocument($id)
    {
        $user = Auth::user();
        $patient = $this->getOrCreatePatient($user);

        // Get the document and verify it belongs to this patient
        $document = \Modules\Document\App\Models\Document::where('patient_id', $patient->id)->findOrFail($id);

        if (!\Illuminate\Support\Facades\Storage::exists($document->chemin_fichier)) {
            abort(404, "Fichier introuvable sur le disque.");
        }

        return \Illuminate\Support\Facades\Storage::download($document->chemin_fichier, $document->nom_fichier);
    }

    /**
     * Display doctor availabilities.
     */
    public function disponibilites()
    {
        $user = Auth::user();
        $patient = $this->getOrCreatePatient($user);
        $layoutData = $this->getLayoutData($patient);

        // Récupérer les prochains créneaux disponibles
        $disponibilites = Disponibilite::with('medecin.user')
            ->where('statut', 'disponible')
            ->whereDate('date', '>=', Carbon::today())
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get();

        return view('patient::dashboard.disponibilites', array_merge([
            'user' => $user,
            'patient' => $patient,
            'disponibilites' => $disponibilites,
        ], $layoutData));
    }

    /**
     * Display messages interface.
     */
    public function messages()
    {
        $user = Auth::user();
        $patient = $this->getOrCreatePatient($user);
        $layoutData = $this->getLayoutData($patient);

        return view('patient::dashboard.messages', array_merge([
            'user' => $user,
            'patient' => $patient,
        ], $layoutData));
    }
}
