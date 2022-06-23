<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'id' => 1,
            'name' => '作業前'
        ]);
        Item::create([
            'id' => 2,
            'name' => '実行中'
        ]);
        Item::create([
            'id' => 3,
            'name' => '確認中'
        ]);
        Item::create([
            'id' => 4,
            'name' => '完了'
        ]);
    }
}
