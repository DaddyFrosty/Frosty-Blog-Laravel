<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Provides the posts to the sidebar.
		view()->composer( "layouts.navigation.sidebar", function( $view ) {
			$view
				->with( "posts", \App\Models\Post::ListAllPostsCached() )
				->with( "sidebar_maxlen", \App\Config::$SidebarPostTitleMaxLength );
		});
    }
}
