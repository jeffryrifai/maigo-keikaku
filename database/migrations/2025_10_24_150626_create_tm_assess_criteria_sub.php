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
        Schema::create('tm_assess_criteria_sub', function (Blueprint $table) {
            $table->id();
            $table->string('id_criteria');
            $table->string('nama_sub_kriteria');
            $table->string('sub_type');
            $table->integer('min_value')->default(0);
            $table->integer('max_value')->default(1);
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_assess_criteria_sub');
    }
};
