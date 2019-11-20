<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    function test_unauthenticated_users_may_not_add_replies(){
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    function test_an_authenticate_user_may_participate_in_forum_threads(){
        $this->be($user = factory(User::class)->create());
//        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
        ->assertSee($reply->body);
    }
}
