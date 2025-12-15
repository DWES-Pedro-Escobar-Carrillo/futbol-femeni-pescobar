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
    Schema::table('partits', function (Blueprint $table) {
        // Afegim la columna nullable per si encara no s'ha assignat àrbitre
        $table->foreignId('arbitre_id')->nullable()->constrained('users')->nullOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partits', function (Blueprint $table) {
            //
        });
    }
};
