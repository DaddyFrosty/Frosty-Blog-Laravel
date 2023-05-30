<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BBCode\Facades\BBCode;

use App\Http\Resources\PostListResource;
use App\Models\Post;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PostController extends Controller
{
    public function Index()
	{
		$posts = PostListResource::collection( Post::ListAllPostsCached() );
//		return view( "post.index", [ "posts" => $posts ] );

		$canCreatePost = Post::CanCreate( auth()->user() );
		return inertia( "Post/Index", [ "posts" => $posts, "canCreate" => $canCreatePost ] );
	}

	protected function FetchPostData( string $postId, bool $bbcodeize ) : array | null
	{
		// TO-DO: Check if post is visible.
		$post = Post::where( "url_title", $postId )
			->first();

		if ( !$post )
			return null;

		// Check Visibility.
		if ( !$post->CanView( auth()->user() ) )
			return null;

		$safePost = new PostListResource( $post );
		$safePost = $safePost->resolve();

		if ( $bbcodeize )
			$safePost["body"] = BBCode::parse( $safePost["body"] );

		// Add edit flag.
		$safePost["canEdit"] = $post->CanEdit( auth()->user() );

		return $safePost;
	}

	public function ViewPost( Request $request, $PostId )
	{
		$post = $this->FetchPostData( $PostId, true );
		if ( !$post )
			return abort( 404 );

		return inertia( "Post/ViewPost", [ "post" => $post ] );
	}

	public function EditPostPage( Request $request, $PostId )
	{
		$post = $this->FetchPostData( $PostId, false );
		if ( !$post )
			return abort( 404 );

		return inertia( "Post/ModifyPost", [ "current_post_state" => $post, "isEdit" => true ] );
	}

	protected function ValidatePostData( Request $request ) : array
	{
		try {
			$data = $request->validate([
				"title" => "required|max:255|min:3",
				"body" => "required|min:3",
			]);
		}
		catch ( ValidationException $e ) {
			$errorsArray = array_merge( ...array_values( $e->errors() ) );
			return [ "errors" => $errorsArray ];
		}

		// Validate title.
		$titleError = Post::CanUseTitle( $data["title"] );
		if ( $titleError != null )
		{
			return [ "errors" => [ $titleError ] ];
		}

		return $data;
	}

	// Submit.
	public function ApplyEditsToPost( Request $request, $PostId )
	{
		$data = $this->ValidatePostData( $request );
		if ( isset( $data["errors"] ) )
		{
			return inertia( "Post/ModifyPost", [ "errors" => $data["errors"], "isEdit" => true ] );
		}

		$post = Post::where( "url_title", $PostId )
			->first();

		if ( !$post )
			return abort( 404 );

		// Check Edit Permissions.
		if ( !$post->CanEdit( auth()->user() ) )
			return abort( 403 );

		if ( $data[ "title" ] != $post->title )
		{
			$post->url_title = Post::GenerateUrlTitle( $data[ "title" ] );
			$post->title = $data[ "title" ]; //$request->input( "title" );
		}
		$post->body = $data["body"]; // $request->input( "body" );
		$post->save();

		return redirect()->route( "posts.view_post", [ "PostId" => $post->url_title ] );
	}

	public function CreatePostPage()
	{
		if ( !Post::CanCreate( auth()->user() ) )
			return abort( 403 );

		return inertia( "Post/ModifyPost", [ "isEdit" => false ] );
	}

	// Submit.
	public function CreatePost( Request $request )
	{
		if ( !Post::CanCreate( auth()->user() ) )
			return abort( 403 );

		$data = $this->ValidatePostData( $request );
		if ( isset( $data["errors"] ) )
		{
			return inertia( "Post/ModifyPost", [ "errors" => $data["errors"], "isEdit" => false ] );
		}

		// Create post.
		$post = Post::create([
			"title" => $data[ "title" ],
			"url_title" => Post::GenerateUrlTitle( $data[ "title" ] ),
			"body" => $data[ "body" ],
			"author" => "Frosty", // auth()->user()->username,
		]);
		$post->save();

		return redirect()->route( "posts.view_post", [ "PostId" => $post->url_title ] );
	}
}
