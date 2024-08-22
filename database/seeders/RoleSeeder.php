<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'name' => 'System Admin',
            'email' => 'system.admin@pimorder.com',
            'password' => Hash::make('Test@123'),
        ]);
        $role = Role::firstOrCreate([
            'name' => 'System Admin',
            'guard_name' => 'user-api',
        ]);
        $models = [
            'users',
            'roles',
            'permissions'
        ];
        $permissions = [
            'view',
            'create',
            'update',
            'export',
            'delete'
        ];
        $allperms = collect([]);
       
        foreach ($models as $model){
            foreach ($permissions as $p) {
                $permission = $p.'-'.$model;
                $perm = Permission::create([
                    'name' => $permission,
                    'guard_name' => 'user-api',
                    'group' => $model
                ]);
                $allperms->push($perm->id);
            }
        }
        $role->givePermissionTo($allperms->toArray());
        $role = Role::where('guard_name','user-api')->first();
        $user->syncRoles([$role]);

    }
}
