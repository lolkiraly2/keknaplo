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
        Schema::create('blue_hikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 64);
            $table->foreignId('hike_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->double('distance');
            $table->boolean("isCustomStart");
            $table->integer("start_point");
            $table->boolean("isCustomEnd");
            $table->integer("end_point");
            $table->boolean("completed");
            $table->json('diary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blue_hikes');
    }
};
