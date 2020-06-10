<?php

use App\Category;
use App\Forum;
use App\Post;
use App\Reply;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create(['email' => 'jonierm@gmail.com', 'name' => 'Jonier Murillo Hurtado']);
        factory(User::class, 50)->create(); //50
        factory(Forum::class, 20)->create(); //20
        factory(Post::class, 50)->create(); //50
        factory(Reply::class, 100)->create(); //100
        factory(Category::class, 20)->create();
    }
}
