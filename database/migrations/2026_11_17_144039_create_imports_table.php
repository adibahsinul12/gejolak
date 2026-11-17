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
    Schema::create('imports', function (Blueprint $table) {
        $table->id();
        $table->string('nama_file');
        $table->enum('jenis', ['produsen', 'konsumen']);
        $table->foreignId('market_id')->constrained('markets');
        $table->foreignId('user_id')->constrained('users');
        $table->date('periode_mulai')->nullable();
        $table->date('periode_akhir')->nullable();
        $table->unsignedInteger('jumlah_baris')->default(0);      // harga yang tersimpan
        $table->unsignedInteger('jumlah_dilewati')->default(0);   // baris yang dilewati
        $table->string('status')->default('selesai');             // selesai | dibatalkan
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('imports');
}
};
