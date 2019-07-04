<?php

use Illuminate\Database\Seeder;

class PreachingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('preachings')->insert([
            ["name"=>'Meditations and Homilies'],
            ["name"=>'Recollections'],
            ["name"=>'Retreats'],
            ["name"=>'Classes,etc']
        ]);
        
    }
}







