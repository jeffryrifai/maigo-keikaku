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
        Schema::create('tr_assess', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket');
            $table->string('id_tenant');
            $table->string('id_category');
            $table->string('skor_final');
            $table->string('rekomendasi');
            $table->string('status')->default('open');
            $table->string('keterangan')->nullable();
            $table->string('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_assess');
    }
};
