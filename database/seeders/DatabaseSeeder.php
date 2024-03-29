<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\AppieProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // // create employees
        $users = \App\Models\User::factory(100)->create();

        $company = \App\Models\Company::create([
            'manager_id' => 1,
            'name' => 'Buurtboer',
            'adress' => 'Kerkstraat 1',
            'city' => 'Amsterdam',
            'zip_code' => '1011',
            'country' => 'Nederland',
            'verified' => true,
            'verification_token' => null
        ]);

        $testUser = \App\Models\User::create([
            'first_name' => 'Test',
            'middle_name' => 'van',
            'last_name' => 'User',
            'role' => 'company_admin',
            'password' => '$2y$12$5CeAFIio/UpcRhHUGyOTwun5P1zc5qCybOw7SIvv2kMDOSr6u8HVS', // password123
            'email' => 'gort@gortium.com',
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        $company = \App\Models\Company::create([
            'manager_id' => $testUser->id,
            'name' => 'Raccy IT',
            'adress' => 'Paashaaslaan 69',
            'city' => 'Rotterdam',
            'zip_code' => '1234AB',
            'country' => 'Nederland',
            'verified' => true,
            'verification_token' => null
        ]);

        $testUserEmployee = Employee::create([
            'user_id' => $testUser->id,
            'company_id' => $company->id,
            'joined_at' => Carbon::now(),
        ]);


        // create super admin
        $superAdmin = \App\Models\User::create([
            'first_name' => 'Super',
            'middle_name' => null,
            'last_name' => 'Admin',
            'role' => 'super_admin',
            'password' => '$2y$12$5CeAFIio/UpcRhHUGyOTwun5P1zc5qCybOw7SIvv2kMDOSr6u8HVS', // password123
            'email' => 'admin@buurtboer.nl',
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        // create super admin employee
        \App\Models\Employee::create([
            'user_id' => $superAdmin->id,
            'company_id' => $company->id,
            'joined_at' => Carbon::now(),
        ]);

        $employees = [];

        foreach($users as $user) {
            $employees[] = \App\Models\Employee::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'joined_at' => Carbon::now(),
            ]);
        }

        if(Carbon::now()->formatLocalized('%A') == "Sunday") {
            $next_week = Carbon::now()->addWeek()->week - 1;
        } else {
            $next_week = Carbon::now()->addWeek()->week;
        }

        foreach ($employees as $employee) {
            for ($i=0; $i < 7; $i++) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'week_number' => $next_week,
                    'week_day' => $i + 1,
                    'year' => Carbon::now()->year,
                    'on_site' => rand(1,2) == 1,
                ]);
            }
        }

        for ($i=1; $i < 53; $i++) {
            for ($j=0; $j < 7; $j++) {
                Attendance::create([
                    'employee_id' => 1,
                    'week_number' => $i,
                    'week_day' => $j + 1,
                    'year' => Carbon::now()->year,
                    'on_site' => rand(1, 2) == 1,
                ]);
            }
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
