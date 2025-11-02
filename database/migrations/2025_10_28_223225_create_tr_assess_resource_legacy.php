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
        Schema::create('tr_assess_resource_legacy', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket');
            $table->string('nama_tenant');
            $table->string('perm_vcpu');
            $table->string('perm_memory');
            $table->string('perm_storage');
            $table->string('assess_vcpu');
            $table->string('assess_memory');
            $table->string('assess_storage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_assess_resource_legacy');
    }
};
