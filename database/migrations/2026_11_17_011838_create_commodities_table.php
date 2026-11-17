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
    Schema::create('commodities', function (Blueprint $table) {
        $table->id();
        $table->string('nama')->unique();
        $table->string('satuan')->default('kg');
        $table->string('kelompok')->nullable();
        $table->boolean('untuk_produsen')->default(false);
        $table->boolean('untuk_konsumen')->default(true);
        $table->boolean('dipantau')->default(false);     // ikut deteksi gejolak
        $table->boolean('aktif')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('commodities');
}
};
