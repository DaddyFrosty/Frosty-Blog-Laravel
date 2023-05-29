<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


		\App\Models\Post::create([
			"title" => "How I made this blog",
			"url_title" => "how_i_made_this_blog",
			"author" => "Frosty",
			"body" => "This <b>is</b> how I made my [b]blog[/b] [keyword]test_keyword[/keyword] and [namespace]name-space[/namespace]."
		]);

		\App\Models\Post::create([
			"title" => "How I will destroy Salamunder",
			"url_title" => "how_i_will_destroy_salamunder",
			"author" => "Frosty",
			"body" => "My plan is to embarass him infront of [name]clunky[/name]. Lol.[img]https://cdn.garry.net/wpi/08/m6.jpeg[/img]"
		]);
    }
}
