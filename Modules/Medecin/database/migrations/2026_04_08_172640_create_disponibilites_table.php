<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disponibilites', function (Blueprint $table) {
            $table->id(); // PK
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->enum('statut',['disponible','reserve','indisponible'])->default('disponible');

            $table->foreignId('medecin_id') // FK vers medecins
            ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
            $table->unique(['medecin_id','date','heure_debut']); // Empêche double créneau
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilites');
    }
};
