<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()->count(10)->create();
        for($i=1; $i <= 100; $i++) {
            $company = Company::factory()->create();
            $company->users()->attach( mt_rand(1,count($users)));
        }
    }
}
