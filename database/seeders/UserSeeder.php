<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Création de l'Administrateur
        User::create([
            'name' => 'Admin Projet',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'), // Mot de passe par défaut
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Création du Médecin
        User::create([
            'name' => 'Dr. House',
            'email' => 'medecin@test.com',
            'password' => Hash::make('medecin'),
            'role' => 'medecin',
            'email_verified_at' => now(),
        ]);
    }
}
