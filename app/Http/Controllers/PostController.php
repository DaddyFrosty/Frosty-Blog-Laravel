<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BBCode\Facades\BBCode;

use App\Http\Resources\PostListResource;
use App\Models\Post;

class PostController extends Controller
{
    public function Index()
	{
		$posts = PostListResource::collection( Post::ListAllPostsCached() );
//		return view( "post.index", [ "posts" => $posts ] );
		return inertia( "Post/Index", [ "posts" => $posts ] );
	}

	public function ViewPost( Request $request, $PostId )
	{
		// TO-DO: Check if post is visible.
		$post = Post::where( "url_title", $PostId )
				->first();

		if ( !$post )
			abort( 404 );

//		return view( "post.view_post", [ "post" => $post ] );
		$post_url = str_replace( " ", "_", ucwords( str_replace( "_", " ", $post->url_title ) ) );
		$post = new PostListResource( $post );
		$post["body"] = BBCode::parse( $post["body"] );
		return inertia( "Post/ViewPost", [ "post" => $post, "post_url" => $post_url ] );
	}
}
