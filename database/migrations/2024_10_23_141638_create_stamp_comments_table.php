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
            $table->enum('allapot', ['Rendben', 'Sérült', 'Hiányzik']);
            $table->integer('user_id');
            $table->string('stamp_name');
            $table->string('leiras');
            $table->date('eszleles_datum');
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
