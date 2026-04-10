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
        Schema::create('documents', function (Blueprint $table) {
            $table->id(); // PK
            $table->enum('type_document',['ordonnance','analyse','radio','autre']);
            $table->string('nom_fichier');
            $table->string('chemin_fichier');
            $table->integer('taille_fichier')->nullable();
            $table->dateTime('date_upload');

            $table->foreignId('patient_id')->constrained()->cascadeOnDelete(); // FK

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
