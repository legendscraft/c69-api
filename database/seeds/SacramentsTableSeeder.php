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
            ["name"=>'Confirmations and 1st Holy Communions'],
            ["name"=>'Masses in Churches, Chaplaincies, etc.'],
            ["name"=>'Confessions'],
            ["name"=>'Anointing of the Sick'],
            ["name"=>'Marriages']
        ]);
    }
}



