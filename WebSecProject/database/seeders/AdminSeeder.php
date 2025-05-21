<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->call(PermissionSeeder::class);

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        $adminRole->syncPermissions([
            'add-users',
            'edit-users',
            'delete-users',
            'show-users',
            'show-products',
            'buy-products',
        ]);
    }
}