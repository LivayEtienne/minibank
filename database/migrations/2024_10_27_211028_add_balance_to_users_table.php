<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceToUsersTable extends Migration
{
    /**
     * Exécutez la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance', 10, 2)->default(0); // Ajout de la colonne balance
        });
    }

    /**
     * Annulez la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance'); // Suppression de la colonne balance
        });
    }
}
