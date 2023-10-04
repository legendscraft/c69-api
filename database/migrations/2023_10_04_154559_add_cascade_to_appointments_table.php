<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {


            //
            Schema::table('appointments', function (Blueprint $table) {
                // Add ON DELETE CASCADE to the foreign key constraints
               //$table->foreign('sacrament_id', 'fk_sacrament_records_sacrament')->references('id')->on('sacraments')->onDelete('CASCADE');
               // $table->foreign('gender_id','genderfk')->references('id')->on('genders')->onDelete('CASCADE');
                //$table->foreign('centre_id','centrefk')->references('id')->on('centres')->onDelete('CASCADE');
                //$table->foreign('appointment_frequency_id','appointmentfreqfk')->references('id')->on('appointment_frequencies')->onDelete('CASCADE');
                $table->foreign('user_id','appointmentuuidfk')->references('id')->on('users')->onDelete('CASCADE');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
            $table->dropForeign('genderfk');
            $table->dropForeign('centrefk');
            $table->dropForeign('appointmentfreqfk');
            $table->dropForeign('appointmentuidfk');
         
        });
    }
}
