<?php

use App\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            'Jane Doe',
        ])->each(function ($name) {
            Employee::create(['name' => $name]);
        });
    }
}
