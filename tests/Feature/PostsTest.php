<?php

namespace Tests\Feature;

use App\Forum;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use DatabaseMigrations;

    protected $forum, $user, $post;

    protected function setUp()
    {
        parent::setUp();

        $this->forum = factory(Forum::class)->create();
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->make([
            "user_id" => $this->user->id,
            "forum_id" => $this->forum->id
        ]);
    }

    /** @test */
    public function an_user_logged_can_submit_post()
    {
        $this->withExceptionHandling();

        $this->signIn(); //Inicio de session en modo test

        $this->post->title = null;
        $response = $this->post('/posts', $this->post->toArray());
        $response->assertSessionHasErrors('title');

        $this->post->title = "Nuevo post de pruebas";
        $response = $this->post('/posts', $this->post->toArray());
        $response
        ->assertStatus(302)
        ->assertSessionHas('message', ['success', __("Post created successfully")]);
    }

    /** @test */

    public function an_owner_can_delete_post() {
        $this->withExceptionHandling();

        $this->signIn(); //Inicio de session en modo test

        $post = factory(Post::class)->create([
            "user_id" => $this->user->id,
            "forum_id" => $this->forum->id
        ]);
  
        $response = $this->delete('/posts/' . $post->slug, $this->post->toArray());
        $response->assertStatus(401);

        $this->signIn($this->user); //Inicio de session en modo test
        $response = $this->delete('/posts/' . $post->slug, $this->post->toArray());
        $response
        ->assertStatus(302)
        ->assertSessionHas('message', ['success', __("Post and replies delete sussesfully")]);
    }

    	/** @test */
	public function an_user_logged_can_upload_files_to_post() {
	    $this->withExceptionHandling();

	    $this->signIn();

	    $array = $this->post->toArray();
	    $file = UploadedFile::fake()->image('avatar.jpg');
	    $array['file'] = $file;

	    $this->json('POST', '/posts', $array);

	    Storage::disk('posts')->assertExists($file->hashName());

	    Storage::disk('posts')->assertMissing('test.jpg');
	}
}
