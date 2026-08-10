<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MakeUserSuperAdmin extends Command
{
    protected $signature = 'user:make-super {id=1}';

    protected $description = 'Make a user a Super User';

    public function handle()
    {
        $user = User::find($this->argument('id'));

        if (!$user) {
            $this->error('User not found.');
            return Command::FAILURE;
        }

        // Get or create Super User role
        $role = Role::firstOrCreate([
            'name' => 'Super User',
            'guard_name' => 'web',
        ]);

        // Give ALL permissions to Super User
        $role->syncPermissions(
            Permission::where('guard_name', 'web')->get()
        );

        // Assign Super User role to User ID 1
        $user->syncRoles([$role]);

        // Clear Spatie cache
        app(\Spatie\Permission\PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->info('User successfully made Super User.');
        $this->info('User ID: ' . $user->id);
        $this->info('Name: ' . $user->name);
        $this->info('Role: Super User');

        return Command::SUCCESS;
    }
}