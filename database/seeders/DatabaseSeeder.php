<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ItemSeeder::class);
        \App\Models\User::factory(10)->create();
        \App\Models\Team::factory(10)->create();
        \App\Models\Task::factory(30)->create();
        $this->call(TaskNumberSeeder::class);
        $this->call(TaskTeamSeeder::class);
    }
}
