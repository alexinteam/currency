<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();
        $currences = \App\Models\Currency::all();

        $accounts = [];
        for ($i = 0; $i < 10; $i++) {
            $randomUsr = $users[rand(0,count($users) - 1)];
            $randomCur = $currences[rand(0,count($currences) - 1)];
            if($randomUsr && $randomCur) {
                $account = [
                    'user_id' => $randomUsr->id,
                    'master_currency' => $randomCur->id,
                    'is_receiving' => rand(0,1),
                    'amount' => rand(10000, 100000) / 10,
                ];

                $accounts[] = $account;
            }
        }

        DB::table('account')->insert($accounts);
    }
}
