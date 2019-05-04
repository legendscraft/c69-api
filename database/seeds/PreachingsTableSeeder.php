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
            ["name"=>'Spiritual Direction'],
            ["name"=>'Meditations and Homilies'],
            ["name"=>'Days of Recollection'],
            ["name"=>'Long Retreats'],
            ["name"=>'Classes and Equivalents'],
        ]);
        
    }
}







