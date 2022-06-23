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
            'name' => '作業前'
        ]);
        Item::create([
            'name' => '実行中'
        ]);
        Item::create([
            'name' => '確認中'
        ]);
        Item::create([
            'name' => '完了'
        ]);
    }
}
