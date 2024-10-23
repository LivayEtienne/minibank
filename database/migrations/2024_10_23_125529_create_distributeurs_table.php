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
        Schema::create('distributeurs', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('numero_compte')->unique(); // Numéro de compte
            $table->foreignId('id_user')->constrained('users'); // Lien vers la table users
            $table->integer('solde'); // Solde
            $table->decimal('bonus', 10, 2)->default(0); // Bonus
            $table->timestamps(); // Ajoute created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributeurs');
    }
};
