<?php

namespace Database\Seeders;

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


        $user = \App\Models\User::factory()->create([
                                    'first_name' => 'Super', 
                                    'last_name' => 'Admin',
                                    'username'=>'superadmin',
                                    'email'=>'admin@admin.com',
                                    'password'=> Hash::make('superadmin')
        ]);

        $user->assignRole($role1);
    }
}
