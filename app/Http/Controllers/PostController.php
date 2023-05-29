<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function Index()
	{
		$posts = Post::ListAllPostsCached();
		return view( "post.index", [ "posts" => $posts ] );
	}

	public function ViewPost( Request $request, $PostId )
	{
		// TO-DO: Check if post is visible.
		$post = Post::where( "url_title", $PostId )
				->first();
		
		if ( !$post )
			abort( 404 );

		return view( "post.view_post", [ "post" => $post ] );
	}
}
