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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('nom'); // Nom
            $table->string('prenom'); // Prénom
            $table->string('email')->unique()->after('prenom'); // Ajoute le champ 'email' après le champ 'prenom'
            $table->string('telephone')->unique(); // Numéro de téléphone
            $table->string('photo')->nullable(); // Photo
            $table->date('date_naissance'); // Date de naissance
            $table->string('adresse'); // Adresse
            $table->integer('cni'); // CNI
            $table->enum('role', ['client', 'distributeur', 'agent']); // Rôle
            $table->boolean('statut')->default(false); // Statut (actif ou non)
            $table->date('date_creation')->useCurrent(); // Date de création
            $table->string('password', 100); // Mot de passe
            $table->timestamps(); // Ajoute created_at et updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
