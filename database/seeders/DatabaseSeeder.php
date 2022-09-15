<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Jobs;
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
        // \App\Models\User::factory(10)->create();
        User::create(
            [
                'first_name' => 'admin',
                'last_name' => 'tester',
                'email' => 'admin@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s', time()),
                'password' => bcrypt('password'),
                'about'=> "Ini adalah Admin",
                'role' => "ADMIN",
            ]
        );

        Jobs::create(
            [
                'jobs_title' => 'Fullstack',
                'company_id' => '1',
                'location' => 1,
                'workspace_type' => "WFH",
                'min_salary' => 5000000,
                'max_salary'=> 10000000,
            ]
        );

        Jobs::create(
            [
                'jobs_title' => 'Frontend Dev',
                'company_id' => '2',
                'location' => 2,
                'workspace_type' => "WFH",
                'min_salary' => 5000000,
                'max_salary'=> 10000000,
            ]
        );

    }
}
