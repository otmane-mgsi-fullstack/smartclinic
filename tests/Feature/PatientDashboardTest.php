<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Medecin\App\Models\Medecin;
use Modules\Patient\App\Models\Patient;
use Modules\Document\App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class PatientDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $patientUser;
    protected $patient;
    protected $otherPatientUser;
    protected $otherPatient;
    protected $doctorUser;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un médecin
        $this->doctorUser = User::create([
            'name' => 'Dr. House',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'role' => 'medecin',
        ]);
        $this->doctor = Medecin::create([
            'user_id' => $this->doctorUser->id,
            'specialite' => 'Généraliste',
            'tarif_consultation' => 200,
        ]);

        // Créer le patient 1
        $this->patientUser = User::create([
            'name' => 'Youssef Alami',
            'email' => 'youssef@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $this->patient = Patient::create([
            'user_id' => $this->patientUser->id,
            'cin' => 'YA12345',
            'date_naissance' => '1985-01-01',
        ]);

        // Créer le patient 2 (Autre)
        $this->otherPatientUser = User::create([
            'name' => 'Nour El Houda',
            'email' => 'nour@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $this->otherPatient = Patient::create([
            'user_id' => $this->otherPatientUser->id,
            'cin' => 'NH98765',
            'date_naissance' => '1995-01-01',
        ]);
    }

    /**
     * Test de chargement de toutes les pages de l'espace patient.
     */
    public function test_patient_can_access_dashboard_pages()
    {
        // 1. Accueil
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Youssef Alami');

        // 2. Mes RDV
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.mes_rdvs'));
        $response->assertStatus(200);

        // 3. Mes documents
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.documents'));
        $response->assertStatus(200);

        // 4. Disponibilités
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.disponibilites'));
        $response->assertStatus(200);

        // 5. Messages
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.messages'));
        $response->assertStatus(200);
    }

    /**
     * Test de sécurité sur le téléchargement de documents.
     */
    public function test_patient_document_download_security()
    {
        Storage::fake('local');

        // Créer un document pour le patient 1 (Youssef Alami)
        Storage::put('documents/youssef_file.pdf', 'Contenu de Youssef');
        $docYoussef = Document::create([
            'patient_id' => $this->patient->id,
            'type_document' => 'ordonnance',
            'nom_fichier' => 'youssef_file.pdf',
            'chemin_fichier' => 'documents/youssef_file.pdf',
            'taille_fichier' => 100,
            'date_upload' => now(),
        ]);

        // Créer un document pour le patient 2 (Nour)
        Storage::put('documents/nour_file.pdf', 'Contenu de Nour');
        $docNour = Document::create([
            'patient_id' => $this->otherPatient->id,
            'type_document' => 'analyse',
            'nom_fichier' => 'nour_file.pdf',
            'chemin_fichier' => 'documents/nour_file.pdf',
            'taille_fichier' => 120,
            'date_upload' => now(),
        ]);

        // 1. Youssef peut télécharger son propre document
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.documents.download', $docYoussef->id));
        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=youssef_file.pdf');

        // 2. Youssef ne peut PAS télécharger le document de Nour (doit renvoyer un 404/403)
        $response = $this->actingAs($this->patientUser)
            ->get(route('patient.documents.download', $docNour->id));
        $response->assertStatus(404);
    }
}
