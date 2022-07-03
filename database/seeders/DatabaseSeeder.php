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
        $this->call(UserSeederTable::class);
        $this->call(TeamSeederTable::class);
        $this->call(TaskSeederTable::class);
        $this->call(ExperienceSeederTable::class);
    }
}
