<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PreachingsTableSeeder::class);
         $this->call(SacramentsTableSeeder::class);
         $this->call(AppointmentFrequenciesTableSeeder::class);
         $this->call(GendersTableSeeder::class);
    }
}
