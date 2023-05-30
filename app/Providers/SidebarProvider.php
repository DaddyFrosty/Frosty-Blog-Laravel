<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Post;
use App\Http\Resources\PostCompactResource;
use Inertia\Inertia;

use App\Config;

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
		view()->composer( "layouts.navigation.sidebar", function( $view ) {
			$view
				->with( "posts", PostCompactResource::collection( Post::ListAllPostsCached() )->resolve() );
		});

        // Provides the posts to the sidebar.
		// Inertia.
		Inertia::share( "posts_sidebar", PostCompactResource::collection( Post::ListAllPostsCached() ) );
    }
}
