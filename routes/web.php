<?php

use App\Http\Controllers\PostController;

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

Route::get('/', function () {
//	return view('index');
	return inertia( 'Index' );
})->name( "index" );

// Posts.
Route::get( "posts", [ PostController::class, "Index" ] )->name( "posts.index" );
Route::get( "posts/{PostId}", [ PostController::class, "ViewPost" ] )->name( "posts.view_post" );
