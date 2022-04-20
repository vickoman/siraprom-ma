<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create user default
        $user = User::create([
            'name' => 'administrator', 
            'email' => 'admin@siraprom.com',
            'password' => bcrypt('open$123')
        ]);

        $role = Role::create(['name' => 'Super-Admin', 'color' => '#ff9a86']);
        $user->assignRole([$role->id]);
    }
}
