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
    Schema::create('quotas', function (Blueprint $table) {
        $table->id('Quota_ID');
        $table->unsignedBigInteger('Supervisor_ID'); // Match the type of 'id' in 'users' table
        $table->integer('QuotaNumber');
        $table->timestamps();

        $table->foreign('Supervisor_ID')->references('id')->on('users')->onDelete('cascade');
    });
}




    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotas');
    }
};
