<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create(['name' => 'admin']);
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => 'admin123',
            'role_id' => 1,
            'status' => 1,
            'number' => '123456789',
            'photo' => 'avatar.jpg',
        ]);


        $permissions = Permission::pluck('id','id')->all();
        $role = Role::where('name', 'admin')->first();
        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
