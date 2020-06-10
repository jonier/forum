<?php

namespace Tests\Feature;

use App\Forum;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ForumsTest extends TestCase
{
    use DatabaseMigrations;

    protected $forum;

    /*
    *  Everything we want to initialize, we have to do it in the setUp method
    */

    protected function setUp()
    {
        parent::setUp();
        $this->forum = factory(Forum::class)->create();
    }

    /** @test */
    public function any_can_browse_forums() {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('Forums')
            ->assertSee($this->forum->name);
    }

    /** @test */
    
    public function any_can_show_forum_detail() {
        $response = $this->get('/forums/'. $this->forum->slug);
        $response->assertSee($this->forum->name);
    }

    /** @test */

    public function any_can_submit_forums() {
        $this->withExceptionHandling();

        $forum = factory(Forum::class)->make(['name' => null]);
        $response = $this->post('/forums', $forum->toArray(), ['HTTP_REFERER' => '/']);
        $response->assertSessionHasErrors('name');

        $forum->name = "Nuevo foro de prueba";
        $response = $this->post('/forums', $forum->toArray(), ['HTTP_REFERER' => '/']);
        
        $response
            ->assertStatus(302)
            ->assertSessionHas('message', ['success', __("Forum created successfully")]);
    }

    /** @test */
    public function any_can_search_posts() {
        $this->withExceptionHandling();

        $search = "post";

        $forum1 = factory(Forum::class)->create(['name' => 'missing']);
        $forum2 = factory(Forum::class)->create(['name' => $search]);

        $this->post('/forums/search', ['search' => $search]);

        $response = $this->get('/');

        $response->assertSessionHas('search');

        $response->assertSee($forum2->name);
        $response->assertDontSee($forum1->name);

        $this->post('/forums/search', []);

        $response = $this->get('/');

        $response->assertSessionMissing('search');
        $response->assertSee($forum1->name);

    }
}
