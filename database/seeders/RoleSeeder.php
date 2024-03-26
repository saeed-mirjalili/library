<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->state([
            'name'=>'admin',
            'display_name'=>'Admin'
        ])->create();
        Role::factory()->state([
            'name'=>'change_Manager',
            'display_name'=>'Change Manager'
        ])->create();
        Role::factory()->state([
            'name'=>'create_manager',
            'display_name'=>'Create manager'
        ])->create();
        Role::factory()->state([
            'name'=>'delete_manager',
            'display_name'=>'Delete manager'
        ])->create();
    }
}
