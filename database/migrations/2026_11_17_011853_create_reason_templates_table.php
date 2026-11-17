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
    Schema::create('reason_templates', function (Blueprint $table) {
        $table->id();
        $table->string('teks');
        $table->boolean('aktif')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('reason_templates');
}
};
