<?php

namespace Label;

use Label;
use Tests\TestCase;
use User;

class CreateLabelTest extends TestCase
{

    public function test_add_label()
    {
        $user = \factory(User::class)->create();
        $label = \factory(Label::class)->make();
        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
        ->post('/api/labels/', $label->toArray())
            ->assertStatus(201);
        $this->assertDatabaseHas('labels', ['name' => $label->name]);
    }
}
