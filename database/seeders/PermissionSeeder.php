<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Create Role']);
        Permission::create(['name' => 'Delete Role']);
        Permission::create(['name' => 'Update Role']);

        Permission::create(['name' => 'Create Permission']);
        Permission::create(['name' => 'Delete Permission']);
        Permission::create(['name' => 'Update Permission']);

        $role1 = Role::create(['name' => 'Super-Admin']);

        $user = new User();
                    $user->first_name= 'Super';
                    $user->last_name = 'Admin';
                    $user->username = 'superadmin';
                    $user->email = 'admin@admin.com';
                    $user->password = Hash::make('superadmin');
        $user->save();

        $user->assignRole($role1);
    }
}
