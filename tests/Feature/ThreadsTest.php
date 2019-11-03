<?php

namespace Tests\Feature;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
//    use DatabaseMigrations;
    /**
     * @Threads
     */
    public function test_a_user_can_view_all_threads()
    {
        #step2
        $thread = factory(Thread::class)->create();


        $response = $this->get('/threads');
        $response->assertSee($thread->title);

//        $response->assertStatus(200);

        #step2
//        $response = $this->get('/threads/' . $thread->id);
    }
    public function test_a_user_can_read_a_single_threads()
    {
        #step2
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }
}
