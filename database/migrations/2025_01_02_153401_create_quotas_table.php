<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotas', function (Blueprint $table) {
            $table->id('Quota_ID');
            $table->unsignedBigInteger('Supervisor_ID');
            $table->integer('QuotaNumber');
            $table->timestamps();

            $table->foreign('Supervisor_ID')->references('User_ID')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotas');
    }
};
