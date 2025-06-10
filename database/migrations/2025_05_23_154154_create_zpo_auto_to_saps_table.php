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
        Schema::create('zpo_autotosap', function (Blueprint $table) {
            $table->id();
            $table->string('prod_ord_no', 12)->nullable();
            $table->integer('key_status')->nullable();
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
        Schema::dropIfExists('zpo_autotosap');
    }
};
