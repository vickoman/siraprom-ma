<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-show',
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',
            'project-show',
            'avance-list',
            'avance-create',
            'avance-edit',
            'avance-delete',
            'avance-show',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-show'
        ];
        foreach ($permissions as $permission) {
            //Permission::create(['name' => $permission]);
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
