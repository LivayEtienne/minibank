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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la transaction
            $table->foreignId('id_compte_source')->constrained('clients'); // Clé étrangère vers la table clients
            $table->foreignId('id_compte_destinataire')->constrained('clients'); // Clé étrangère vers la table clients
            $table->foreignId('id_distributeur')->constrained('agents'); // Clé étrangère vers la table agents
            $table->decimal('montant', 10, 2); // Montant de la transaction
            $table->enum('type', ['envoi', 'retrait', 'depot']); // Type de transaction
            $table->dateTime('date')->useCurrent(); // Date de la transaction
            $table->decimal('frais', 10, 2)->default(0); // Frais de transaction
            $table->timestamps(); // Ajoute created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
