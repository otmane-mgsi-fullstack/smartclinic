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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // PK
            $table->text('message');
            $table->dateTime('date_envoi');
            $table->enum('type',['rdv','paiement','systeme']);
            $table->string('titre')->nullable();
            $table->boolean('est_lue')->default(false);

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // FK

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
