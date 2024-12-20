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
        Schema::create('cpoints', function (Blueprint $table) {
            $table->id();
            $table->string('nev', 50);
            $table->foreignId('stage_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->double('szelesseg');
            $table->double('hosszusag');
            $table->string('leiras')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpoints');
    }
};
