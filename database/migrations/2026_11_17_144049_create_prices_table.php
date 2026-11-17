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
    Schema::create('prices', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->foreignId('commodity_id')->constrained('commodities');
        $table->enum('jenis', ['produsen', 'konsumen']);
        $table->foreignId('market_id')->constrained('markets');
        $table->decimal('harga', 12, 2);
        $table->string('sumber')->default('impor');               // impor | manual
        $table->foreignId('import_id')->nullable()->constrained('imports')->nullOnDelete();
        $table->timestamps();

        // Satu harga per tanggal, komoditas, jenis, dan pasar. Impor ulang memperbarui, bukan menggandakan.
        $table->unique(['tanggal', 'commodity_id', 'jenis', 'market_id'], 'prices_unik');
        // Mempercepat pengambilan deret harga untuk grafik dan deteksi gejolak.
        $table->index(['commodity_id', 'market_id', 'tanggal'], 'prices_seri');
    });
}

public function down(): void
{
    Schema::dropIfExists('prices');
}
};
