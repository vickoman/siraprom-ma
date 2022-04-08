<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'name' => 'Victor Diaz', 
            'email' => 'vickoman.dev@gmail.com',
            'password' => bcrypt('open$123')
        ]);
    }
}
