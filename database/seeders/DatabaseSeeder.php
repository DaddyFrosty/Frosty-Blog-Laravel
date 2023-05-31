<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Post;
use App\Models\User;
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

		$adminPerms = Permission::create([
			"name" => "Admin",
			"color" => [ 255, 215, 0 ],
			"order" => 10,
			"permissions" => [ "*" => true ],
		]);

		$userPerms = Permission::create([
			"name" => "User",
			"color" => [],
			"order" => 0,
			"permissions" => [],
			"default" => true,
		]);

		$defaultUserGuid = User::GenerateGuid();
		$steamId = env( 'DEFAULT_USER_STEAMID64' );

		$defaultUser = User::create([
			"uid" => $defaultUserGuid,
			"name" => "Frosty",
			"avatar" => User::GetRandomIdenticonUrl( $defaultUserGuid, $steamId ),
			"steamid64" => $steamId,
			"permission_id" => $adminPerms->id,
		]);

		Post::create([
			"title" => "How I made this blog",
			"url_title" => "how_i_made_this_blog",
			"author_uid" => $defaultUser->uid,
			"body" => "This <b>is</b> how I made my [b]blog[/b] [keyword]test_keyword[/keyword] and [namespace]name-space[/namespace]."
		]);

		Post::create([
			"title" => "How I will destroy Salamunder",
			"url_title" => "how_i_will_destroy_salamunder",
			"author_uid" => $defaultUser->uid,
			"body" => "My plan is to embarass him infront of [name]clunky[/name]. Lol.[img]https://cdn.garry.net/wpi/08/m6.jpeg[/img]"
		]);

		Permission::FlushCache();
		User::FlushCache();
		Post::FlushCache();
    }
}
