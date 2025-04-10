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
            $table->string('name', 64);
            $table->foreignId('stage_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->double('lat');
            $table->double('lon');
            $table->string('description', 255)->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
