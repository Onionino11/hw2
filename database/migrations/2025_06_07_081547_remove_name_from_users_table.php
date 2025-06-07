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
        Schema::table('users', function (Blueprint $table) {
            // Verifichiamo se la colonna esiste prima di rimuoverla
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Aggiungiamo nuovamente la colonna name in caso di rollback
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
        });
    }
};
