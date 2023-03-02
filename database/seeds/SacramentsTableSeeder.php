<?php

use Illuminate\Database\Seeder;

class SacramentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('sacraments')->insert([
            ["name"=>'Baptisms'],
            ["name"=>'Confirmations and 1st H Communion'],
            ["name"=>'Masses outside ctr and oc'],
            ["name"=>'Confessions'],
            ["name"=>'Spiritual Direction'],
            ["name"=>'Anointing of the Sick'],
            ["name"=>'Matrimony']
        ]);
    }
}







