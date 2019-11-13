<?php

namespace Tests\Feature;
use App\Thread;
use App\User;
use Tests\TestCase;

class CreateThreadsTest extends TestCase{

    function test_a_logged_in_user_can_create_new_threads(){
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())->assertSee($thread->title);

    }
    function test_an_authenticated_user_can_create_new_forum_threads(){
        $this->actingAs(create(User::class));

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
