<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Task;
use App\Models\TaskNumber;
use Faker\Factory as Faker;

class TaskSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('ja_JP');

        for ($i = 0; $i < 30; $i++) {
            // タスク作成のチーム取得
            $random_id = rand(1, 10);
            $team = Team::with('users')->find($random_id);
            // チーム内メンバーのid取得（配列）
            foreach ($team->users as $user) {
                $user_array[] = $user->id;
            }
            $task_number = TaskNumber::where('team_id', $team->id)->orderBy('task_count', 'desc')->first();

            // チーム内からランダムで１つのidを取得
            $key = array_rand($user_array);
            $user_id = $user_array[$key];

            if (!$task_number) {
                $task_count = TaskNumber::create([
                    'team_id' => $team->id,
                    'task_count' => 1
                ]);
                Task::create([
                    'title' => $faker->word(),
                    'contents' => $faker->realText(),
                    'user_id' => $user_id,
                    'team_id' => $task_count->team_id,
                    'item_id' => $faker->numberBetween(1, 4),
                    'task_count' => $task_count->task_count
                ]);
            } else {
                $task_count = $task_number->task_count;
                $create_task = TaskNumber::create([
                    'team_id' => $random_id,
                    'task_count' => $task_count + 1
                ]);

                Task::create([
                    'title' => $faker->word(),
                    'contents' => $faker->realText(),
                    'user_id' => $user_id,
                    'team_id' => $create_task->team_id,
                    'item_id' => $faker->numberBetween(1, 4),
                    'task_count' => $create_task->task_count
                ]);
            }

            // チーム内メンバーのidをリセット
            unset($user_array);
        }
    }
}
