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
        Schema::create('zgi_autotosap', function (Blueprint $table) {
            $table->id();
            $table->string('prod_ord_no', 12)->nullable();
            $table->string('plant', 4)->nullable();
            $table->dateTime('prod_start')->nullable();
            $table->dateTime('prod_end')->nullable();
            $table->string('material_number', 18)->nullable();
            $table->integer('qty')->nullable();
            $table->string('uom_material_number', 3)->nullable();
            $table->string('reject_flag', 1)->nullable();
            $table->string('sloc', 4)->nullable();
            $table->string('recipient', 12)->nullable();
            $table->string('batch_number', 10)->nullable();
            $table->string('mrp_controller', 3)->nullable();
            $table->integer('key_status')->nullable();
            $table->dateTime('insert_time')->nullable();
            $table->dateTime('update_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zgi_autotosap');
    }
};
