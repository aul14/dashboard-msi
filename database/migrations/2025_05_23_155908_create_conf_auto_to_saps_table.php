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
        Schema::create('conf_autotosap', function (Blueprint $table) {
            $table->id();
            $table->string('prod_ord_no', 12)->nullable();
            $table->string('plant', 4)->nullable();
            $table->dateTime('prod_start')->nullable();
            $table->dateTime('prod_end')->nullable();
            $table->string('operation_no', 4)->nullable();
            $table->string('work_center', 8)->nullable();
            $table->double('parameter_1')->nullable();
            $table->double('parameter_2')->nullable();
            $table->double('parameter_3')->nullable();
            $table->double('parameter_4')->nullable();
            $table->double('parameter_5')->nullable();
            $table->double('parameter_6')->nullable();
            $table->string('parameter_desc_1')->nullable();
            $table->string('parameter_desc_2')->nullable();
            $table->string('parameter_desc_3')->nullable();
            $table->string('parameter_desc_4')->nullable();
            $table->string('parameter_desc_5')->nullable();
            $table->string('parameter_desc_6')->nullable();
            $table->double('conf_qty')->nullable();
            $table->string('recipient', 12)->nullable();
            $table->integer('key_status')->nullable()->default(0);
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
        Schema::dropIfExists('conf_autotosap');
    }
};
