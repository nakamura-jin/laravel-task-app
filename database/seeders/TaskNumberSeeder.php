<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\TaskNumber;

class TaskNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            $task_number = TaskNumber::where('team_id', $task->team_id)->orderBy('task_count', 'desc')->first();
            if (!$task_number) {
                $createTaskNumber = TaskNumber::create([
                    'team_id' => $task->team_id,
                    'task_count' => 1,
                ]);

                $data = [
                    'task_count' => $createTaskNumber->task_count
                ];

                $task->update($data);
            } else {
                $task_count = $task_number->task_count;
                $createTaskNumber = TaskNumber::create([
                    'team_id' => $task->team_id,
                    'task_count' => $task_count + 1,
                ]);

                $data = [
                    'task_count' => $createTaskNumber->task_count
                ];

                $task->update($data);
            }
        }
    }
}
