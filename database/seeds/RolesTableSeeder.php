<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Admin Role', 'level' => 5],
            ['name' => 'User', 'slug' => 'user', 'description' => 'User Role', 'level' => 1],
            ['name' => 'Unverified', 'slug' => 'unverified', 'description' => 'Unverified Role', 'level' => 0]
        ];

        foreach ($arr as $item) {
            Role::create($item);
        }

    }
}