<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->restrictOnDelete();
            $table->foreignId('cinema_id')->constrained('cinemas')->restrictOnDelete();
            $table->foreignId('auditorium_id')->constrained('auditoriums')->restrictOnDelete();
            $table->foreignId('type_id')->constrained('types')->restrictOnDelete();
            $table->dateTime('visit_date');
            $table->string('row');
            $table->string('seat');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
