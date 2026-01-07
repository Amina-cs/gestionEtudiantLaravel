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
    Schema::create('etudiants', function (Blueprint $table) {
        $table->id();
        // La clé étrangère vers l'admin
        $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
        $table->foreignId('filiere_id')->constrained('filieres');

        
        $table->string('cin')->unique();
        $table->string('nom');
        $table->string('prenom');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('tel')->nullable();
        $table->string('niveau');
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
