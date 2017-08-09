<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['parent_id' => 0, 'icon' => null, 'title' => '全局配置', 'path' => '/sys', 'component' => 'Home', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 1, 'icon' => null, 'title' => '菜单', 'path' => 'menu', 'component' => 'Menu', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 1, 'icon' => null, 'title' => '角色组', 'path' => 'role', 'component' => 'Role', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 1, 'icon' => null, 'title' => '权限', 'path' => 'permission', 'component' => 'Permission', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 1, 'icon' => null, 'title' => '后台账户', 'path' => 'user', 'component' => 'User', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 0, 'icon' => null, 'title' => '运营管理', 'path' => '/yunying', 'component' => 'Yunying', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '活动', 'path' => 'activity', 'component' => 'Activity', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '主题', 'path' => 'theme', 'component' => 'Theme', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '目的地', 'path' => 'destination', 'component' => 'Destination', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '领队', 'path' => 'leader', 'component' => 'Leader', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '攻略', 'path' => 'raider', 'component' => 'Raider', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '美食', 'path' => 'food', 'component' => 'Food', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 6, 'icon' => null, 'title' => '民宿', 'path' => 'su', 'component' => 'Su', 'sort' => 0, 'is_show' => 'T'],
            ['parent_id' => 0, 'icon' => null, 'title' => '网站内容', 'path' => '/web', 'component' => 'Web', 'sort' => 0, 'is_show' => 'T'],
        ];

        if (Menu::count() === 0) {
            Menu::insert($menus);
        }
    }
}
