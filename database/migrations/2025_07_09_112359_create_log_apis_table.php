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
        Schema::create('log_api', function (Blueprint $table) {
            $table->id();
            $table->string('type_table')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('request_log')->nullable();
            $table->text('response_log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_api');
    }
};
