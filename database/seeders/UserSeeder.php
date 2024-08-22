<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'System Admin',
            'email' => 'admin@pimorder.com',
            'password' => Hash::make('Test@123'),
        ]);
        $role = Role::findById(1);
        $this->syncRoles([$role]);
    }
}
