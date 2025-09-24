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
        Schema::create('zpo_saptoauto', function (Blueprint $table) {
            $table->id();
            $table->string('prod_ord_no', 12)->nullable();
            $table->double('reservation')->nullable();
            $table->integer('item')->nullable();
            $table->string('plant', 4)->nullable();
            $table->string('order_type', 4)->nullable();
            $table->double('batch')->nullable();
            $table->string('batch_code', 50)->nullable();
            $table->string('status_batch')->default('RECEIVED')->nullable();
            $table->dateTime('production_start')->nullable();
            $table->double('qty_production')->nullable();
            $table->string('material_code', 18)->nullable();
            $table->string('material_desc', 40)->nullable();
            $table->string('uom_material_code', 3)->nullable();
            $table->string('product_family', 18)->nullable();
            $table->string('mrp_controller', 3)->nullable();
            $table->string('work_center_10', 8)->nullable();
            $table->string('work_center_20', 8)->nullable();
            $table->string('work_center_30', 8)->nullable();
            $table->string('work_center_40', 8)->nullable();
            $table->string('work_center_50', 8)->nullable();
            $table->string('work_center_60', 8)->nullable();
            $table->string('work_center_70', 8)->nullable();
            $table->string('work_center_80', 8)->nullable();
            $table->string('work_center_90', 8)->nullable();
            $table->string('work_center_100', 8)->nullable();
            $table->string('material_component', 18)->nullable();
            $table->string('material_component_desc', 40)->nullable();
            $table->integer('material_packing_flag')->nullable();
            $table->double('qty_component')->nullable();
            $table->string('uom_component', 3)->nullable();
            $table->integer('key_status')->nullable();
            $table->string('zdata1', 40)->nullable();
            $table->string('zdata2', 40)->nullable();
            $table->string('zdata3', 40)->nullable();
            $table->dateTime('last_update_by_sap')->nullable();
            $table->dateTime('last_update_by_automation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zpo_saptoauto');
    }
};
