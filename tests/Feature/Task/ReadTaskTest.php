<?php

namespace Task;

use Illuminate\Support\Facades\DB;
use Task;
use Tests\TestCase;
use User;

class ReadTaskTest extends TestCase
{

    public function test_read_tasks()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        DB::table('task_user')->insert(
            [
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]
        );

        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
        ->get('/api/tasks/')
            ->assertStatus(200)
            ->assertSee($task->title)
            ->assertSee($task->id);
    }

    public function test_user_can_not_read__other_users_tasks()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
            ->get('/api/tasks/')
            ->assertDontSee($task->title);
    }

    public function test_read_a_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        DB::table('task_user')->insert(
            [
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]
        );

        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
            ->get('/api/tasks/'.$task->id)
            ->assertStatus(200)
            ->assertSee($task->title)
            ->assertSee($task->id);
    }

    public function test_user_can_not_read_other_users_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
            ->get('/api/tasks/'.$task->id)
            ->assertStatus(401);
          }
}
