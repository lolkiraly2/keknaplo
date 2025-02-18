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
        Schema::create('stamp_comments', function (Blueprint $table) {
            $table->id();
            $table->enum('state', ['Rendben', 'Sérült', 'Hiányzik']);
            $table->foreignId('user_id')->constrained();
            $table->string('stamp_mtsz_id',20);
            $table->date('detection');
            $table->string('comment', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamp_comments');
    }
};
