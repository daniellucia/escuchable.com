<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Usuarios
        Permission::create(['name' => 'show.edit']);
        Permission::create(['name' => 'show.delete']);
        Permission::create(['name' => 'show.publish']);
        Permission::create(['name' => 'show.unpublish']);

        //Admin
        Permission::create(['name' => 'category.create']);
        Permission::create(['name' => 'category.edit']);
        Permission::create(['name' => 'category.delete']);
        Permission::create(['name' => 'user.list']);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('show.edit');
        $role->givePermissionTo('show.delete');
        $role->givePermissionTo('show.publish');
        $role->givePermissionTo('show.unpublish');

        $role = Role::create(['name' => 'moderator']);
        $role->givePermissionTo(Permission::all());

        $user = User::find(1);
        $user->assignRole('admin');
    }
}
