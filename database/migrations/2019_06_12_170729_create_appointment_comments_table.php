<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment');
            $table->dateTime('mdate');
            $table->integer('appointment_id')->unsigned();
            $table->foreign('appointment_id')->references('id')->on('appointments');
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
        Schema::dropIfExists('appointment_comments');
    }
}
