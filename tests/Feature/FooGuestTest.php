<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FooGuestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    function test_guest_may_not_create_threads()
    {
        $this->withExceptionHandling()->get('/threads/create')
            ->assertRedirect('/login');
        $this->withExceptionHandling()->post('/threads', [])
            ->assertRedirect('/login');


//        $this->withExceptionHandling();
//        $this->post('/threads')
//            ->assertRedirect('/login');

    }
    function test_an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
