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
            $table->string('mtsz_id', 20);
            $table->string('stamp_id', 20);
            $table->foreignId('stage_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 60);
            $table->string('location', 255);
            $table->string('location_description', 255);
            $table->string('address', 255);
            $table->enum('availability', ['Folyamatos', 'Nyitvatartás szerint']);
            $table->string('opening_hours',128);
            $table->double('lat');
            $table->double('lon');
            $table->string('stamp_url', 128);
            $table->string('picture1_url', 128);
            $table->string('picture2_url', 128)->nullable();
            $table->string('picture3_url', 128)->nullable();
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
