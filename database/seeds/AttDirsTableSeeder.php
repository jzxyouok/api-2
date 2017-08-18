<?php

use App\AttDir;
use Illuminate\Database\Seeder;

class AttDirsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            ['title' => 'avatar', 'parent_id' => 0, 'is_sys' => 'T'],
        ];

        if (!!AttDir::count()) {
            return true;
        }
        foreach ($arr as $item) {
            AttDir::create($item);
        }


    }
}
