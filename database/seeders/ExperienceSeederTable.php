<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Team;
use App\Models\Task;
use App\Models\TaskNumber;

class ExperienceSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('ja_JP');


        // 体験用ユーザー
        User::create([
            'name' => '体験用ユーザー',
            'worker_number' => '99999',
            'password' => Hash::make('testtest'),
            'role_id' => 2
        ]);

        // 体験用チーム
        $team = Team::create([
            'name' => 'テストチーム',
            'user_id' => 21,
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $user = User::where('id', $i)->get();
            $team->users()->attach($user);
        }

        // 体験用タスク
        TaskNumber::create([
            'team_id' => 11,
            'task_count' => 1
        ]);
        Task::create([
            'title' => $faker->word(),
            'contents' => $faker->realText(),
            'user_id' => 1,
            'team_id' => 11,
            'item_id' => $faker->numberBetween(1, 4),
            'task_count' => 1
        ]);

        TaskNumber::create([
            'team_id' => 11,
            'task_count' => 2
        ]);
        Task::create([
            'title' => $faker->word(),
            'contents' => $faker->realText(),
            'user_id' => 21,
            'team_id' => 11,
            'item_id' => $faker->numberBetween(1, 4),
            'task_count' => 2
        ]);
    }
}
