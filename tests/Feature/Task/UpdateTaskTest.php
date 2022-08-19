<?php

namespace Task;

use Enums\TaskStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Label;
use Notifications\TaskClosed;
use Task;
use Tests\TestCase;
use User;

class UpdateTaskTest extends TestCase
{
    public function test_update_a_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        DB::table('task_user')->insert(
            [
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]
        );

        $newTask = \factory(Task::class)->make();
        $this->withHeaders(['authorization' => 'Bearer ' . $user->token])
            ->patch('/api/tasks/' . $task->id, $newTask->toArray())
            ->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['title' => $newTask->title]);
    }

    public function test_user_can_not_update_another_user_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        $newTask = \factory(Task::class)->make();
        $this->withHeaders(['authorization' => 'Bearer ' . $user->token])
            ->patch('/api/tasks/' . $task->id, $newTask->toArray())
            ->assertStatus(401);
    }

    public function test_add_labels_to_a_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create();

        DB::table('task_user')->insert(
            [
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]
        );

        $label1 = \factory(Label::class)->create();
        $label2 = \factory(Label::class)->create();
        $label3 = \factory(Label::class)->create();
        $label4 = \factory(Label::class)->create();

        $this->withHeaders(['authorization' => 'Bearer ' . $user->token])
            ->patch('/api/tasks/' . $task->id, ['labels' => [$label1->id, $label2->id, $label3->id, $label4->id]])
            ->assertStatus(200);
        $this->assertDatabaseHas('label_task', ['task_id' => $task->id, 'label_id' => $label4->id]);
    }

    public function test_notify_while_closing_a_task()
    {
        $user = \factory(User::class)->create();
        $task = \factory(Task::class)->create(['status' => TaskStatusEnum::OPEN]);

        DB::table('task_user')->insert(
            [
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]
        );

        $requestArray = ['status' => TaskStatusEnum::CLOSE];

        $this->withHeaders(['authorization' => 'Bearer ' . $user->token])
            ->patch('/api/tasks/' . $task->id, $requestArray)
            ->assertStatus(200);
        $updatedTask = Task::findOrFail($task->id);
        $this->assertEquals($updatedTask->status, TaskStatusEnum::CLOSE);

        Notification::assertSentTo($user, TaskClosed::class);
    }
}
