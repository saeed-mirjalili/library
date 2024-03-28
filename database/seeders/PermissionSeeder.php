<?php

namespace Database\Seeders;

use App\Models\panel\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()->state([
            'name'=>'exhibit',
            'display_name'=>'exhibitor'
        ])->create();
        Permission::factory()->state([
            'name'=>'change',
            'display_name'=>'changer'
        ])->create();
        Permission::factory()->state([
            'name'=>'create',
            'display_name'=>'creator'
        ])->create();
        Permission::factory()->state([
            'name'=>'delete',
            'display_name'=>'Detergent'
        ])->create();
    }
}
