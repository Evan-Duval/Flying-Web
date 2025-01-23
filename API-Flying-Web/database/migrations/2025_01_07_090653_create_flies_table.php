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
        Schema::create('flies', function (Blueprint $table) {
            $table->id();
            $table->dateTime('takeoffTime');
            $table->dateTime('landingTime');
            $table->string('flightNumber');
            $table->integer('flightDuration');
            $table->timestamps();
            $table->foreignId('plane_id')->constrained()->onDelete('cascade');
            $table->foreignId('aeroport_depart_id')->constrained('aeroports')->onDelete('cascade');
            $table->foreignId('aeroport_arrive_id')->constrained('aeroports')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flies');
    }
};
