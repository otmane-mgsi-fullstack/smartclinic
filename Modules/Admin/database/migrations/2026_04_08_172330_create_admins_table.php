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
Schema::create('admins', function (Blueprint $table) {
        $table->id(); // PK
        $table->enum('niveau_acces', ['super_admin','admin']);

        $table->foreignId('user_id') // FK vers users
        ->unique()
            ->constrained()
            ->cascadeOnDelete();

        $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
