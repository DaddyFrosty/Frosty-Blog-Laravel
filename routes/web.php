<?php

use App\Http\Controllers\PostController;

// Steam Login.
use kanalumaddela\LaravelSteamLogin\Facades\SteamLogin;
use App\Http\Controllers\Auth\SteamLoginController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// middleware( "NeedsPermission:PERM1,PERM2" )

Route::get('/', function () {
//	return view('index');
	return inertia( 'Index' );
})->name( "index" )->middleware( "NeedsPermission:LOL,xD" );

// Login.
SteamLogin::routes( ["controller" => SteamLoginController::class ] );
Route::get( "logout", [ SteamLoginController::class, "Logout" ] )->name('logout');

// Posts.
Route::get( "posts/create", [ PostController::class, "CreatePostPage" ] )->name( "posts.create_post" );
Route::post( "posts/create", [ PostController::class, "CreatePost" ] )->name( "posts.submit_create_post" );

Route::get( "posts", [ PostController::class, "Index" ] )->name( "posts.index" );
Route::delete( "posts", [ PostController::class, "ClearCache" ] )->name( "posts.clear_cache" );
Route::get( "posts/{PostId}", [ PostController::class, "ViewPost" ] )->name( "posts.view_post" );

Route::get( "posts/{PostId}/edit", [ PostController::class, "EditPostPage" ] )->name( "posts.edit_post" );
Route::post( "posts/{PostId}/edit", [ PostController::class, "ApplyEditsToPost" ] )->name( "posts.submit_edit_post" );

Route::delete( "posts/{PostId}", [ PostController::class, "DeletePost" ] )->name( "posts.delete_post" );
