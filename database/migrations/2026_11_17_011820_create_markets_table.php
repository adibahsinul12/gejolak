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
    Schema::create('markets', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->enum('jenis', ['produsen', 'konsumen']);
        $table->string('lokasi')->nullable();
        $table->boolean('aktif')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('markets');
}
};
