<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\App\Models\Admin;
use Modules\Medecin\App\Models\Medecin;
use Modules\Medecin\App\Models\Disponibilite;
use Modules\Patient\App\Models\Patient;
use Modules\Rdv\App\Models\RendezVous;
use Modules\Consultation\App\Models\Consultation;
use Modules\Ordonnance\App\Models\Ordonnance;
use Modules\Document\App\Models\Document;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création de l'Administrateur
        $adminUser = User::create([
            'name' => 'Admin Projet',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Admin::create([
            'user_id' => $adminUser->id,
            'niveau_acces' => 'super_admin',
        ]);

        // 2. Création du Médecin
        $medecinUser = User::create([
            'name' => 'Jean Boubbou',
            'email' => 'medecin@test.com',
            'password' => Hash::make('medecin'),
            'role' => 'medecin',
            'email_verified_at' => now(),
        ]);

        $medecin = Medecin::create([
            'user_id' => $medecinUser->id,
            'specialite' => 'Médecine Générale',
            'tarif_consultation' => 250.00,
            'biographie' => 'Médecin généraliste d\'expérience diplômé de la Faculté de Médecine.',
        ]);

        // 3. Création des Patients
        $patientsData = [
            [
                'name' => 'Youssef Alami',
                'email' => 'youssef@test.com',
                'password' => 'youssef',
                'cin' => 'YA12345',
                'date_naissance' => '1972-04-12',
                'adresse' => 'Boulevard Anfa, Casablanca',
            ],
            [
                'name' => 'Nour El Houda',
                'email' => 'nour@test.com',
                'password' => 'nour123',
                'cin' => 'NH98765',
                'date_naissance' => '1995-08-22',
                'adresse' => 'Avenue de France, Rabat',
            ],
            [
                'name' => 'Karim Mansouri',
                'email' => 'karim@test.com',
                'password' => 'karim123',
                'cin' => 'KM55443',
                'date_naissance' => '1987-11-05',
                'adresse' => 'Gueliz, Marrakech',
            ],
        ];

        $patients = [];
        foreach ($patientsData as $pData) {
            $user = User::create([
                'name' => $pData['name'],
                'email' => $pData['email'],
                'password' => Hash::make($pData['password']),
                'role' => 'patient',
                'email_verified_at' => now(),
            ]);

            $patients[] = Patient::create([
                'user_id' => $user->id,
                'cin' => $pData['cin'],
                'date_naissance' => $pData['date_naissance'],
                'adresse' => $pData['adresse'],
            ]);
        }

        // 4. Création des Créneaux (Disponibilités) et des RDV
        $today = now()->toDateString();
        
        // RDV 1 : Aujourd'hui (Youssef Alami) - Terminé
        $dispo1 = Disponibilite::create([
            'medecin_id' => $medecin->id,
            'date' => $today,
            'heure_debut' => '09:00:00',
            'heure_fin' => '09:30:00',
            'statut' => 'reserve',
        ]);

        $rdv1 = RendezVous::create([
            'date_heure' => "$today 09:00:00",
            'statut' => 'termine',
            'motif' => 'Suivi de tension artérielle',
            'notes' => 'Tension légèrement élevée, prescrit HTA control.',
            'patient_id' => $patients[0]->id,
            'medecin_id' => $medecin->id,
            'disponibilite_id' => $dispo1->id,
        ]);

        // Créer une consultation et ordonnance pour le RDV terminé
        $consultation = Consultation::create([
            'date_consultation' => $today,
            'diagnostic' => 'Hypertension modérée',
            'symptomes' => 'Céphalées matinales, vertiges légers.',
            'traitement' => 'Prendre Amlodipine 5mg une fois par jour.',
            'montant' => 250.00,
            'rendez_vous_id' => $rdv1->id,
        ]);

        Ordonnance::create([
            'date_prescription' => $today,
            'medicaments' => "Amlodipine 5mg (Boite de 30)\n1 comprimé le matin au petit déjeuner.",
            'instructions' => "Prendre pendant 1 mois. Contrôle de la tension dans 4 semaines.",
            'consultation_id' => $consultation->id,
        ]);

        // RDV 2 : Aujourd'hui (Nour El Houda) - Planifié
        $dispo2 = Disponibilite::create([
            'medecin_id' => $medecin->id,
            'date' => $today,
            'heure_debut' => '11:00:00',
            'heure_fin' => '11:30:00',
            'statut' => 'reserve',
        ]);

        RendezVous::create([
            'date_heure' => "$today 11:00:00",
            'statut' => 'planifie',
            'motif' => 'Première consultation / Bilan sanguin',
            'notes' => 'Patient demande un bilan complet annuel.',
            'patient_id' => $patients[1]->id,
            'medecin_id' => $medecin->id,
            'disponibilite_id' => $dispo2->id,
        ]);

        // RDV 3 : Demain (Karim Mansouri) - Planifié
        $tomorrow = now()->addDay()->toDateString();
        $dispo3 = Disponibilite::create([
            'medecin_id' => $medecin->id,
            'date' => $tomorrow,
            'heure_debut' => '15:00:00',
            'heure_fin' => '15:30:00',
            'statut' => 'reserve',
        ]);

        RendezVous::create([
            'date_heure' => "$tomorrow 15:00:00",
            'statut' => 'planifie',
            'motif' => 'Renouvellement traitement diabète',
            'notes' => 'Diabétique de type 2, traitement régulier.',
            'patient_id' => $patients[2]->id,
            'medecin_id' => $medecin->id,
            'disponibilite_id' => $dispo3->id,
        ]);

        // 5. Création de documents de test
        // Créer les répertoires nécessaires
        if (!Storage::exists('documents')) {
            Storage::makeDirectory('documents');
        }

        // Fichiers factices pour de vrais téléchargements
        Storage::put('documents/radio_poumons.pdf', 'Contenu factice d\'un fichier de Radiographie Pulmonaire.');
        Storage::put('documents/bilan_sanguin.pdf', 'Contenu factice d\'un fichier de Bilan Sanguin.');

        Document::create([
            'patient_id' => $patients[0]->id, // Youssef
            'type_document' => 'radio',
            'nom_fichier' => 'radio_poumons.pdf',
            'chemin_fichier' => 'documents/radio_poumons.pdf',
            'taille_fichier' => 12450, // octets
            'date_upload' => now()->subDays(2),
        ]);

        Document::create([
            'patient_id' => $patients[1]->id, // Nour
            'type_document' => 'analyse',
            'nom_fichier' => 'bilan_sanguin.pdf',
            'chemin_fichier' => 'documents/bilan_sanguin.pdf',
            'taille_fichier' => 8420,
            'date_upload' => now()->subDay(),
        ]);
    }
}
