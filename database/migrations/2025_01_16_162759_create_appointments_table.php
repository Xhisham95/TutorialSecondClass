<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id('Appointment_ID');
        $table->foreignId('Student_ID')->constrained('users')->onDelete('cascade');
        $table->foreignId('Supervisor_ID')->constrained('users')->onDelete('cascade');
        $table->date('Appointment_Date');
        $table->time('Appointment_Time');
        $table->string('Status'); // Pending, Approved, Rejected
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
