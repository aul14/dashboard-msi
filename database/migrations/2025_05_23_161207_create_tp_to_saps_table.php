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
        Schema::create('tp_tosap', function (Blueprint $table) {
            $table->id();
            $table->string('sapid_code', 21)->nullable();
            $table->string('plant', 4)->nullable();
            $table->string('material_number', 18)->nullable();
            $table->string('storage_location', 4)->nullable();
            $table->string('receiving', 4)->nullable();
            $table->dateTime('transfer_posting')->nullable();
            $table->string('qty_transfer_posting', 13)->nullable();
            $table->string('mrp_controller', 3)->nullable();
            $table->string('kode_batch_vendor')->nullable();
            $table->string('person_recipient', 12)->nullable();
            $table->integer('key_status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tp_tosap');
    }
};
