<?php

namespace Tests\Feature;
use App\Thread;
use App\User;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase{

//    use DatabaseMigrations;

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
    function test_an_authenticated_user_can_create_new_forum_threads_use_sign_in(){
//        $this->actingAs(create(User::class));
        $this->signIn();
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
