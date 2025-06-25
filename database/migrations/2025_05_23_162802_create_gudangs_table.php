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
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id(); // Kolom id auto increment
            $table->string('nama')->nullable(); // Nama gudang
            $table->string('barcode')->unique()->nullable(); // Kode unik
            $table->string('satuan')->nullable(); // Satuan barang (misal pcs, box)
            $table->unsignedInteger('jumlah_stok')->default(0); // Jumlah stok awal
            $table->string('version')->nullable(); // Versi produk / stok
            $table->boolean('aktif')->default(true); // Status aktif / tidak
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudangs');
    }
};
