<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
            [
                'currency' =>  Currency::USD,
            ],
            [
                'currency' =>  Currency::EUR,
            ],
            [
                'currency' =>  Currency::RON,
            ],
            [
                'currency' =>  Currency::COP,
            ],
            [
                'currency' =>  Currency::GBP,
            ],
        ]);
    }
}
