<?php

namespace Modules\Medecin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\App\Models\Patient;
use Modules\Document\App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentManageController extends Controller
{
    /**
     * Display a listing of documents / dossiers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $patientId = $request->input('patient_id');

        $query = Document::with('patient.user');

        if ($patientId) {
            $query->where('patient_id', $patientId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom_fichier', 'like', "%{$search}%")
                  ->orWhere('type_document', 'like', "%{$search}%")
                  ->orWhereHas('patient.user', function($patientQuery) use ($search) {
                      $patientQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $documents = $query->latest()->paginate(15)->withQueryString();
        $patients = Patient::with('user')->get();

        // Statistiques médecin pour layout
        $medecin = Auth::user()->load('medecin')->medecin;
        $nbRdvAujourdhui = $medecin->rendezVous()->whereDate('date_heure', now()->toDateString())->count();
        $nbTotalPatients = Patient::count();

        return view('medecin::dashboard.documents.index', [
            'documents' => $documents,
            'patients' => $patients,
            'selectedPatientId' => $patientId,
            'search' => $search,
            'nbRdvAujourdhui' => $nbRdvAujourdhui,
            'nbTotalPatients' => $nbTotalPatients,
        ]);
    }

    /**
     * Show the form for creating a new document.
     */
    public function create(Request $request)
    {
        $patients = Patient::with('user')->get();
        $preselectedPatientId = $request->input('patient_id');

        $medecin = Auth::user()->load('medecin')->medecin;
        $nbRdvAujourdhui = $medecin->rendezVous()->whereDate('date_heure', now()->toDateString())->count();
        $nbTotalPatients = Patient::count();

        return view('medecin::dashboard.documents.create', [
            'patients' => $patients,
            'preselectedPatientId' => $preselectedPatientId,
            'nbRdvAujourdhui' => $nbRdvAujourdhui,
            'nbTotalPatients' => $nbTotalPatients,
        ]);
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'type_document' => 'required|in:ordonnance,analyse,radio,autre',
            'file' => 'required|file|max:10240', // 10 Mo max
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            
            // Stockage dans le dossier privé storage/app/documents
            $path = $file->store('documents');
            $size = $file->getSize();

            Document::create([
                'patient_id' => $request->patient_id,
                'type_document' => $request->type_document,
                'nom_fichier' => $originalName,
                'chemin_fichier' => $path,
                'taille_fichier' => $size,
                'date_upload' => now(),
            ]);

            return redirect()->route('medecin.documents.index', ['patient_id' => $request->patient_id])
                ->with('success', 'Le document a été téléversé avec succès.');
        }

        return back()->withErrors(['file' => 'Une erreur est survenue lors du téléversement du fichier.']);
    }

    /**
     * Download the specified document.
     */
    public function download($id)
    {
        $document = Document::findOrFail($id);

        if (!Storage::exists($document->chemin_fichier)) {
            abort(404, 'Fichier introuvable sur le disque.');
        }

        return Storage::download($document->chemin_fichier, $document->nom_fichier);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Suppression physique du fichier
        if (Storage::exists($document->chemin_fichier)) {
            Storage::delete($document->chemin_fichier);
        }

        // Suppression de l'enregistrement en base
        $document->delete();

        return redirect()->back()->with('success', 'Le document a été supprimé du dossier.');
    }
}
