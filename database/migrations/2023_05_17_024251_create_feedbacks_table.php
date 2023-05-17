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

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id');
            $table->text('body');
            $table->timestamps();

            $table->foreign('letter_id')->references('id')->on('letters');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
