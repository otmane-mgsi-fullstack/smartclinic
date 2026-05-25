<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Medecin\App\Models\Medecin;
use Modules\Patient\App\Models\Patient;
use Modules\Document\App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DoctorFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected $doctorUser;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un médecin
        $this->doctorUser = User::create([
            'name' => 'Dr. Test',
            'email' => 'drtest@example.com',
            'password' => bcrypt('password'),
            'role' => 'medecin',
        ]);

        $this->doctor = Medecin::create([
            'user_id' => $this->doctorUser->id,
            'specialite' => 'Cardiologue',
            'tarif_consultation' => 300,
        ]);
    }

    /**
     * Test de l'accès au tableau de bord médecin.
     */
    public function test_doctor_can_access_dashboard()
    {
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('medecin::dashboard.index');
        $response->assertSee('Dr. Test');
    }

    /**
     * Test de l'accès au listing des patients et de la création de patient.
     */
    public function test_doctor_can_manage_patients()
    {
        // 1. Accès au listing
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.patients.index'));
        $response->assertStatus(200);

        // 2. Accès au formulaire de création
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.patients.create'));
        $response->assertStatus(200);

        // 3. Soumission de la création
        $patientData = [
            'name' => 'Patient Un',
            'email' => 'patientun@example.com',
            'password' => 'secret123',
            'cin' => 'PT776655',
            'date_naissance' => '1990-05-15',
            'adresse' => 'Avenue Mohammed V, Rabat',
        ];

        $response = $this->actingAs($this->doctorUser)
            ->post(route('medecin.patients.store'), $patientData);

        $response->assertRedirect(route('medecin.patients.index'));
        
        // Vérifier l'insertion
        $this->assertDatabaseHas('users', ['email' => 'patientun@example.com', 'role' => 'patient']);
        $this->assertDatabaseHas('patients', ['cin' => 'PT776655']);

        // 4. Édition du patient
        $patient = Patient::where('cin', 'PT776655')->first();
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.patients.edit', $patient->id));
        $response->assertStatus(200);

        // Mise à jour
        $updateData = [
            'name' => 'Patient Un Modifie',
            'email' => 'patientun@example.com',
            'cin' => 'PT776655',
            'date_naissance' => '1990-05-15',
            'adresse' => 'Nouvelle Adresse, Casablanca',
        ];

        $response = $this->actingAs($this->doctorUser)
            ->put(route('medecin.patients.update', $patient->id), $updateData);

        $response->assertRedirect(route('medecin.patients.index'));
        $this->assertDatabaseHas('users', ['name' => 'Patient Un Modifie']);
        $this->assertDatabaseHas('patients', ['adresse' => 'Nouvelle Adresse, Casablanca']);

        // 5. Suppression du patient
        $response = $this->actingAs($this->doctorUser)
            ->delete(route('medecin.patients.destroy', $patient->id));

        $response->assertRedirect(route('medecin.patients.index'));
        $this->assertDatabaseMissing('users', ['email' => 'patientun@example.com']);
        $this->assertDatabaseMissing('patients', ['cin' => 'PT776655']);
    }

    /**
     * Test de la gestion des documents.
     */
    public function test_doctor_can_manage_documents()
    {
        Storage::fake('local');

        // Créer un patient
        $patientUser = User::create([
            'name' => 'Alex Dupont',
            'email' => 'alex@example.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'cin' => 'AX54321',
            'date_naissance' => '1988-10-10',
        ]);

        // 1. Accéder aux documents
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.documents.index'));
        $response->assertStatus(200);

        // 2. Accéder à l'upload
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.documents.create'));
        $response->assertStatus(200);

        // 3. Uploader un document
        $file = UploadedFile::fake()->create('analyse_sang.pdf', 500); // 500 KB

        $uploadData = [
            'patient_id' => $patient->id,
            'type_document' => 'analyse',
            'file' => $file,
        ];

        $response = $this->actingAs($this->doctorUser)
            ->post(route('medecin.documents.store'), $uploadData);

        // Devrait rediriger vers l'index avec le filtre patient_id
        $response->assertRedirect(route('medecin.documents.index', ['patient_id' => $patient->id]));

        // Vérifier l'insertion en base
        $this->assertDatabaseHas('documents', [
            'patient_id' => $patient->id,
            'type_document' => 'analyse',
            'nom_fichier' => 'analyse_sang.pdf',
        ]);

        $document = Document::where('patient_id', $patient->id)->first();
        
        // Vérifier que le fichier est bien stocké physiquement
        Storage::assertExists($document->chemin_fichier);

        // 4. Télécharger le document
        $response = $this->actingAs($this->doctorUser)
            ->get(route('medecin.documents.download', $document->id));
        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=analyse_sang.pdf');

        // 5. Supprimer le document
        $response = $this->actingAs($this->doctorUser)
            ->delete(route('medecin.documents.destroy', $document->id));

        $this->assertDatabaseMissing('documents', ['id' => $document->id]);
        Storage::assertMissing($document->chemin_fichier);
    }
}
