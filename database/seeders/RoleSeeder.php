<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $worker = Role::create(['name' => 'worker']);
        $client = Role::create(['name' => 'client']);

        Permission::create(['name' => 'dashadmin.users'])->syncRoles([$admin, $worker]);
        Permission::create(['name' => 'dashadmin.companies'])->assignRole($admin);
        Permission::create(['name' => 'dashadmin.config'])->assignRole($admin);
        Permission::create(['name' => 'dashclient.index'])->assignRole($client);


    }
}
