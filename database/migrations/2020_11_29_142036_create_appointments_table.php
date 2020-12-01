<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timing_slot_id');
            $table->foreign('timing_slot_id')->references('id')->on('timing_slots');
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->integer('phone')->nullable(false);
            $table->timestamp('created_at')->default(date("Y-m-d H:i:s"));
            $table->timestamp('appointment_date')->nullable(true);;
            $table->boolean('is_payment_completed')->default(0);
            $table->string('status')->default('Payment Pending');
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
