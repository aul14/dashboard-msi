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
        Schema::create('log_good_issue', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();
            $table->string('batch')->nullable();
            $table->string('material_number')->nullable();
            $table->double('quantity')->nullable();
            $table->string('sloc')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_good_issue');
    }
};
