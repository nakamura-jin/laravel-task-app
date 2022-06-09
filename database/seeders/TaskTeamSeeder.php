<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Task;

class TaskTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = Task::all();

        foreach($tasks as $task) {
            $data = [
                'team_id' => $task->team_id,
                'user_id' => $task->user_id
            ];

            $team_id = Team::find($data['team_id']);
            $team_id->users()->sync($data);
        }
    }
}
