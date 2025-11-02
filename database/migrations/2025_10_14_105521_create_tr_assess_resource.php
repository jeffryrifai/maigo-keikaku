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
        Schema::create('tr_assess_resource', function (Blueprint $table) {
            $table->id();
            $table->string('id_assess')->nullable();
            $table->string('id_criteria');
            $table->string('vcpu');
            $table->string('memory');
            $table->string('storage');
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_assess_resource');
    }
};
