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
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();
            $table->string('mtsz_id');
            $table->string('pecset_id');
            $table->foreignId('stage_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('nev');
            $table->string('helyszin');
            $table->string('helyszin_leiras');
            $table->string('cim');
            $table->string('elerhetoseg');
            $table->string('nyitvatartas');
            $table->double('szelesseg');
            $table->double('hosszusag');
            $table->string('lenyomat_url');
            $table->string('kep1_url');
            $table->string('kep2_url')->nullable();
            $table->string('kep3_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamps');
    }
};
