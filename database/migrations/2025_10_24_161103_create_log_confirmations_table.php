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
        Schema::create('log_confirmation', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();
            $table->string('batch')->nullable();
            $table->enum('type', ['RM', 'Charging', 'Mixing', 'Transfer', 'DownTime'])->nullable();
            $table->string('type_message')->nullable();
            $table->double('qty')->nullable();
            $table->string('duration')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_confirmation');
    }
};
