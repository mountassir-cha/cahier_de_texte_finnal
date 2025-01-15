<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cahier_textes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->date('date');
            $table->text('content');
            $table->timestamps();

            // Index pour optimiser les recherches
            $table->index(['professor_id', 'course_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cahier_textes');
    }
}; 