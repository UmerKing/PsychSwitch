<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timing_slot_id');
            $table->foreign('timing_slot_id')->references('id')->on('timing_slots');
            $table->decimal('rate',9,3)->nullable(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_rates');
    }
}
