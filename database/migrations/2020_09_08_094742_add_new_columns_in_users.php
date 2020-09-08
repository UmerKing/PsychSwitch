<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable(false);
            $table->unsignedBigInteger('city_id')->nullable(false);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('designation')->nullable(true);
            $table->unsignedBigInteger('speciality_id')->nullable(true);
            $table->foreign('speciality_id')->references('id')->on('specialities');
            $table->unsignedBigInteger('sub_speciality_id')->nullable(true);
            $table->foreign('sub_speciality_id')->references('id')->on('sub_specialities');
            $table->string('pmdc')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->dropColumn('designation');
            $table->dropForeign(['speciality_id']);
            $table->dropColumn('speciality_id');
            $table->dropForeign(['sub_speciality_id']);
            $table->dropColumn('sub_speciality_id');
            $table->dropColumn('pmdc');
        });
    }
}
