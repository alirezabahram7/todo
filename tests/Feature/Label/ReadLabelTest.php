<?php

namespace Label;

use Label;
use Tests\TestCase;
use User;

class ReadLabelTest extends TestCase
{

    public function test_read_labels()
    {
        $user = \factory(User::class)->create();
        $label = \factory(Label::class)->create();

        $this->withHeaders(['authorization' => 'Bearer '.$user->token])
        ->get('/api/labels')
            ->assertStatus(200);
    }
}
