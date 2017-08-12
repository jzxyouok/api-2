<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('name', 'User')->first();
        $adminRole = Role::where('name', 'Admin')->first();
        $permissions = Permission::all();

        /**
         * Add Users
         *
         */
        if (User::where('email', '=', '676659348@qq.com')->first() === null) {

            $newUser = User::create([
                'avatar' => 'https://cn.vuejs.org/images/logo.png',
                'name' => 'bing',
                'email' => '676659348@qq.com',
                'password' => bcrypt('bing8u'),
                'api_token' => str_random(60),
                'disable_at' => null,
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (User::where('email', '=', '953547161@qq.com')->first() === null) {

            $newUser = User::create([
                'avatar' => 'https://cn.vuejs.org/images/xiaozhuanlan.png',
                'name' => 'liyanchun',
                'email' => '953547161@qq.com',
                'password' => bcrypt('lyc123'),
                'api_token' => str_random(60),
                'disable_at' => null,
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }
    }
}