<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => '1',
                'name' =>'Admin'
            ],
            [
                'id' => '2',
                'name' =>'Employee'
            ]
        ];

        foreach ($roles as $key => $value) {
            Roles::create([
                'name' =>$value["name"]
            ]);
        }
    }
}
