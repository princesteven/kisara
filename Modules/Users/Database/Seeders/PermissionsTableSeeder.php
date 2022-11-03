<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['guard_name' => 'api', 'name' => 'users:create']);
        Permission::create(['guard_name' => 'api', 'name' => 'users:view']);
        Permission::create(['guard_name' => 'api', 'name' => 'users:update']);
        Permission::create(['guard_name' => 'api', 'name' => 'users:delete']);
        Permission::create(['guard_name' => 'api', 'name' => 'user:view']);

        Permission::create(['guard_name' => 'api', 'name' => 'roles:create']);
        Permission::create(['guard_name' => 'api', 'name' => 'roles:view']);
        Permission::create(['guard_name' => 'api', 'name' => 'roles:update']);
        Permission::create(['guard_name' => 'api', 'name' => 'roles:delete']);
        Permission::create(['guard_name' => 'api', 'name' => 'role:view']);
    }
}
