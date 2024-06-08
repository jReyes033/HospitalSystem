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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('Full Name');
            $table->unsignedBigInteger('DoctorID');
            $table->unsignedBigInteger('AppointmentID');
            $table->unsignedBigInteger('MedicalRecordID');
            $table->foreign('DoctorID')->references('id')->on('doctors');
            $table->foreign('AppointmentID')->references('id')->on('appointments');
            $table->foreign('MedicalRecordID')->references('id')->on('medical_records');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
