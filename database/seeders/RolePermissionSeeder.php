<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{

    public function run()
    {


        $permissions = [

            'user-create',
            'user-edit',
            'user-delete',
            'user-view',

            'role-create',
            'role-edit',
            'role-delete',
            'role-view',

            'permission-create',
            'permission-edit',
            'permission-delete',
            'permission-view',

        ];


        foreach($permissions as $permission){

            Permission::firstOrCreate([
                'name'=>$permission,
                'guard_name'=>'web'
            ]);

        }



        $super = Role::firstOrCreate([
            'name'=>'Super User',
            'guard_name'=>'web'
        ]);


        $manager = Role::firstOrCreate([
            'name'=>'Sales Manager',
            'guard_name'=>'web'
        ]);


        $executive = Role::firstOrCreate([
            'name'=>'Sales Executive',
            'guard_name'=>'web'
        ]);


        $user = Role::firstOrCreate([
            'name'=>'User',
            'guard_name'=>'web'
        ]);



        $super->givePermissionTo(Permission::all());


        $manager->givePermissionTo([
            'user-view',
            'user-create',
            'user-edit',
        ]);


        $executive->givePermissionTo([

            'user-view'

        ]);

    }
}