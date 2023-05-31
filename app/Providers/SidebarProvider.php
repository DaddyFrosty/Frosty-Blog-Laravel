<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Post;
use App\Http\Resources\PostCompactResource;
use Illuminate\Support\Str;
use Inertia\Inertia;

use App\Config;
use Symfony\Component\Console\Output\ConsoleOutput;

class SidebarProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//		dd(PostCompactResource::collection( Post::ListAllPostsCached() )->resolve());
		$postsCollection = PostCompactResource::collection( Post::ListAllPostsCached() );
//		$output = new ConsoleOutput();
//		$output->writeln( Str::uuid() );

		view()->composer( "layouts.navigation.sidebar", function( $view ) use ( &$postsCollection ) {
			$view
				->with( "posts", $postsCollection->resolve() );
		});

        // Provides the posts to the sidebar.
		// Inertia.
		Inertia::share( "posts_sidebar", $postsCollection );
    }
}
