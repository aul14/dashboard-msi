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
        Schema::create('log_mesin', function (Blueprint $table) {
            $table->id();
            $table->dateTime('datetime');
            $table->text('description')->nullable();
            $table->string('mrp_controller', 3)->nullable(); //WHP = PARAQUAT, WHG = GLYPOSATE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_mesin');
    }
};
