<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'dashboard-admin']);
        Permission::create(['name'=>'dashboard-user']);
        Permission::create(['name'=>'manage-data-user']);

        Permission::create(['name'=>'user-add-keluarga']);
        Permission::create(['name'=>'user-edit-keluarga']);
        Permission::create(['name'=>'user-delete-keluarga']);
        Permission::create(['name'=>'user-share-keluarga']);

        Permission::create(['name'=>'admin-add-keluarga']);
        Permission::create(['name'=>'admin-edit-keluarga']);
        Permission::create(['name'=>'admin-delete-keluarga']);
        Permission::create(['name'=>'admin-share-keluarga']);

        Role::create(['name'=>'admin']);
        Role::create(['name'=>'user']);

        $roleAdmin = Role::findByName('admin');
        $roleUser = Role::findByName('user');

        $roleAdmin->givePermissionTo(
            'dashboard-admin', 
            'dashboard-user',
            'manage-data-user',
            'admin-add-keluarga',
            'admin-edit-keluarga',
            'admin-delete-keluarga',
            'admin-share-keluarga'
        );

        $roleAdmin->givePermissionTo(
            'dashboard-user',
            'user-add-keluarga',
            'user-edit-keluarga',
            'user-delete-keluarga',
            'user-share-keluarga'
        );

    }

}
