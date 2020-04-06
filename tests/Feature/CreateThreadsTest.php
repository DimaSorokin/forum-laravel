<?php

namespace Tests\Feature;
use App\Channel;
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

        $thread = create(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    function test_an_authenticated_user_can_create_new_forum_threads_use_sign_in(){
//        $this->actingAs(create(User::class));
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


    function test_threads_required_a_titles(){
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }
    function test_threads_required_a_body(){
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }
    function test_threads_required_a_valid_channel(){
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = []){

        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
