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
        $table->string('role')->default('enumerator');
        $table->string('jenis_default')->nullable();
        $table->foreignId('market_id')->nullable()->constrained('markets')->nullOnDelete();
        $table->boolean('aktif')->default(true);
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropConstrainedForeignId('market_id');
        $table->dropColumn(['role', 'jenis_default', 'aktif']);
    });
}
};
