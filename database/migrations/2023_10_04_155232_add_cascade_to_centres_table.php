<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeToCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('centres', function (Blueprint $table) {
            // Add ON DELETE CASCADE to the foreign key constraint
            $table->foreign('user_id','centreuid')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('centres', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign('centreuid');
        });
    }
}
