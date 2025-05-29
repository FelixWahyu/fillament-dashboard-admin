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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('faktur_id')->constrained('fakturs', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('kode_produk');
            $table->bigInteger('harga');
            $table->bigInteger('subtotal');
            $table->integer('qty');
            $table->integer('hasil_qty');
            $table->integer('diskon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
