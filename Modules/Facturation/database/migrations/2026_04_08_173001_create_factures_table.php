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
        Schema::create('factures', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('numero_facture')->unique();
            $table->date('date_emission');
            $table->decimal('montant_total',10,2);
            $table->decimal('montant_paye',10,2)->default(0);
            $table->enum('statut',['non_paye','partiel','paye'])->default('non_paye');

            $table->foreignId('consultation_id')->unique()->constrained()->cascadeOnDelete(); // FK 1-1

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
