<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id('File_ID');
            $table->unsignedBigInteger('Student_ID');
            $table->unsignedBigInteger('Topic_ID');
            $table->string('File_Name');
            $table->string('File_Path');
            $table->timestamp('Uploaded_At');
            $table->timestamps();

            $table->foreign('Student_ID')->references('User_ID')->on('users')->onDelete('cascade');
            $table->foreign('Topic_ID')->references('Topic_ID')->on('project_topics')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_uploads');
    }
};
