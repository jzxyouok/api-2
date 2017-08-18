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
            ['name' => '角色管理', 'slug' => 'all.role', 'description' => '可以对角色进行任何操作', 'model' => 'App\Role'],
            ['name' => '权限管理', 'slug' => 'all.permission', 'description' => '可以对权限进行任何操作', 'model' => 'App\Permission'],
            ['name' => '账户管理', 'slug' => 'all.user', 'description' => '可以对账户进行任何操作', 'model' => 'App\User'],
            ['name' => '附件管理', 'slug' => 'all.attachment', 'description' => '可以对附件进行任何操作', 'model' => 'App\Attachment'],
        ];

        if (!!Permission::count()) {
            return true;
        }

        foreach ($arr as $item) {
            Permission::create($item);
        }

    }
}
