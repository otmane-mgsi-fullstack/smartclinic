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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id(); // PK
            $table->dateTime('date_heure');
            $table->enum('statut',['planifie','annule','termine'])->default('planifie');
            $table->string('motif')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('patient_id')->constrained()->cascadeOnDelete(); // FK
            $table->foreignId('medecin_id')->constrained()->cascadeOnDelete(); // FK
            $table->foreignId('disponibilite_id')->unique()->constrained()->cascadeOnDelete(); // FK 1-1

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
