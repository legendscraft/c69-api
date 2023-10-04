<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeToSacramentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sacrament_records', function (Blueprint $table) {
            //
            $table->foreign('sacrament_id')->references('id')->on('sacraments')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sacrament_records', function (Blueprint $table) {
           
               // Remove the foreign key constraints
               $table->dropForeign(['sacrament_id']);
               $table->dropForeign(['user_id']);
        });
    }
}
