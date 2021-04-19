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
        $p1 = Permission::create(['name' => 'Create Role']);
        $p2 = Permission::create(['name' => 'Delete Role']);
        $p3 = Permission::create(['name' => 'Update Role']);

        $p4 = Permission::create(['name' => 'Create Permission']);
        $p5 = Permission::create(['name' => 'Delete Permission']);
        $p6 = Permission::create(['name' => 'Update Permission']);

        $role1 = Role::create(['name' => 'Super-Admin']);

        $role1->givePermissionTo($p1 , $p2, $p3, $p4, $p5, $p6);
        
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
