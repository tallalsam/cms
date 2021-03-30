<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class superAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['first_name' => 'Super', 
                                    'last_name' => 'Admin',
                                    'username'=>'superadmin',
                                    'email'=>'admin@admin.com',
                                    'password'=> Hash::make('superadmin')]);
    }
}
