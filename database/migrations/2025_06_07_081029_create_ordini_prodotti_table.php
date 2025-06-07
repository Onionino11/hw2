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
        Schema::create('ordini_prodotti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordine_id')->constrained('ordini')->onDelete('cascade');
            $table->unsignedBigInteger('prodotto_id');
            $table->string('nome');
            $table->decimal('prezzo', 8, 2);
            $table->unsignedInteger('quantita')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordini_prodotti');
    }
};
