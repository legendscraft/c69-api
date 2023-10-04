<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeToAppointmentComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_comments', function (Blueprint $table) {
            // Add ON DELETE CASCADE to the foreign key constraint
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_comments', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['appointment_id']);
        });
    }
}
