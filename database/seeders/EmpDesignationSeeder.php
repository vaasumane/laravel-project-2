<?php

namespace Database\Seeders;

use App\Models\EmployeeDesignation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designation = [
            [
                "id"=>"1",
                "designation_name"=>"PHP Developer",
            ],
            [
                "id"=>"2",
                "designation_name"=>"Frontend Developer",
            ],
            [
                "id"=>"3",
                "designation_name"=>"Graphics Designer",
            ]
        ];

        foreach ($designation as $key => $value) {
            EmployeeDesignation::create([
                "designation_name"=>$value['designation_name']
            ]);
        }
    }
}
