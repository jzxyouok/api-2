<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            ['name' => '角色管理', 'slug' => 'all.role', 'description' => '可以对角色进行任何操作', 'model' => 'Role'],
            ['name' => '权限管理', 'slug' => 'all.permission', 'description' => '可以对权限进行任何操作', 'model' => 'Permission'],
            ['name' => '账户管理', 'slug' => 'all.user', 'description' => '可以对账户进行任何操作', 'model' => 'User']
        ];

        Permission::insert($arr);
    }
}
