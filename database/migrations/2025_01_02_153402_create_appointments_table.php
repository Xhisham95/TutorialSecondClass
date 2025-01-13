<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('Appointment_ID');
            $table->unsignedBigInteger('Student_ID');
            $table->unsignedBigInteger('Supervisor_ID');
            $table->date('Appointment_Date');
            $table->time('Appointment_Time');
            $table->enum('Status', ['Pending', 'Approved', 'Rejected']);
            $table->timestamps();

            $table->foreign('Student_ID')->references('User_ID')->on('users')->onDelete('cascade');
            $table->foreign('Supervisor_ID')->references('User_ID')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
