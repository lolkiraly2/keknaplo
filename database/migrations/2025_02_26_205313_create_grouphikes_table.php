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
        Schema::create('grouphikes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('start_point_name', 50);
            $table->string('end_point_name', 50);
            $table->string('location', 50);
            $table->date('date');
            $table->time('gatheringtime');
            $table->time('starttime');
            $table->boolean('public');
            $table->string('password')->nullable();
            $table->integer('maxparticipants');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('customroute_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('description', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grouphikes');
    }
};
