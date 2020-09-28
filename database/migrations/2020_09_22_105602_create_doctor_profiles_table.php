<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable(true);
            $table->string('designation')->nullable(false);
            $table->string('pmdc')->nullable(false);
            $table->string('about_me')->nullable(true);
            $table->string('avatar')->default('default.jpg');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('speciality_id')->nullable(false);
            $table->foreign('speciality_id')->references('id')->on('specialities');
            $table->unsignedBigInteger('sub_speciality_id')->nullable(true);
            $table->foreign('sub_speciality_id')->references('id')->on('sub_specialities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_profiles');
    }
}
