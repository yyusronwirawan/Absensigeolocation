<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};


class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
        $roleAdminOPD = Role::create(['name' => 'Admin OPD']);
        $rolePegawai = Role::create(['name' => 'Pegawai']);

        foreach (config('permission.list_permissions') as $permission) {
            foreach ($permission['lists'] as $list) {
                Permission::create(['name' => $list]);
            }
        }

        $userSuperAdmin = User::first();
        $userSuperAdmin->assignRole('super admin');
        $roleSuperAdmin->givePermissionTo(Permission::all());
    }
}
