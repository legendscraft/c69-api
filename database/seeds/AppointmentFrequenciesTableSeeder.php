<?php

use Illuminate\Database\Seeder;

class AppointmentFrequenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_frequencies')->insert([
            ["name"=>'Daily','days'=>1],
            ["name"=>'Weekly','days'=>7],
            ["name"=>'Fortnightly','days'=>14],
            ["name"=>'Monthly','days'=>30],
            ["name"=>'Annually','days'=>365]
        ]);
    }
}
