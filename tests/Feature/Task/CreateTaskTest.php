<?php

namespace Task;

use Task;
use Tests\TestCase;
use User;

class CreateTaskTest extends TestCase
{
    public function test_add_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->make();
        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
        ->post('/api/tasks/', $task->toArray())
            ->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => $task->title]);
    }
}
