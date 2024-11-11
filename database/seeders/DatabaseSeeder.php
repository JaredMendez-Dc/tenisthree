<?php

namespace Database\Seeders;

use App\Models\teni;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Country::factory(50)->create();
        \App\Models\Cliente::factory(25)->create();
        teni::factory(15)->create();
        //Table cliente_teni
         for($i=1; $i<=15; $i++){
            $teni = Teni::find($i);
            $teni->clientes()->attach(random_int(1,25));
         }
    }
}
