<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		if ( config( "app.env" ) !== "local" )
			URL::forceScheme( "https" );

		// To avoid nested data: data.
		JsonResource::withoutWrapping();

		Inertia::share( "app", [
			"name" => env( "APP_NAME" )
		] );

//		if ( isset( app ) )
//		Inertia::share( "user", [] );
		// Moved to HandleInertiaRequests.php
    }
}
