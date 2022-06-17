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
        $this->call(RoleSeederTable::class);
        \App\Models\User::factory(20)->create();
        \App\Models\Team::factory(10)->create();
        $this->call(TeamSeederTable::class);
        $this->call(TaskSeederTable::class);
    }
}
