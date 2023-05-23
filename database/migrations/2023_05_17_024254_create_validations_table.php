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
        Schema::disableForeignKeyConstraints();

        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id');
            $table->unsignedBigInteger('applicant_signature');
            $table->unsignedBigInteger('deputy_signature')->nullable()->default(null);
            $table->unsignedBigInteger('manager_signature')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('letter_id')->references('id')->on('letters');
            $table->foreign('applicant_signature')->references('id')->on('signatures');
            $table->foreign('deputy_signature')->references('id')->on('signatures');
            $table->foreign('manager_signature')->references('id')->on('signatures');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};
