<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'projects.create',
            'projects.edit',
            'projects.delete',
            'projects.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'tasks.assign',
            'tasks.view',
            'comments.create',
            'comments.delete.own',
            'tags.manage',
            'users.manage',
            'activitylog.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($permissions);

        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->givePermissionTo([
            'projects.create',
            'projects.edit',
            'projects.view',
            'tasks.create',
            'tasks.edit',
            'tasks.assign',
            'tasks.view',
            'comments.create',
            'comments.delete.own',
            'tags.manage',
            'activitylog.view',
        ]);

        $member = Role::firstOrCreate(['name' => 'member']);
        $member->givePermissionTo([
            'projects.view',
            'tasks.view',
            'tasks.edit',
            'comments.create',
            'comments.delete.own',
            'activitylog.view',
        ]);

        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
