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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id(); // PK
            $table->date('date_consultation');
            $table->text('diagnostic')->nullable();
            $table->text('symptomes')->nullable();
            $table->text('traitement')->nullable();
            $table->decimal('montant',8,2);

            $table->foreignId('rendez_vous_id')
                ->unique()
                ->constrained('rendez_vous') // correct
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
