<?php

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
        // $this->call(UsersTableSeeder::class);
        factory(User::class, 50)->create();
        factory(Forum::class, 20)->create();
        factory(Post::class, 50)->create();
        factory(Reply::class, 100)->create();
    }
}
