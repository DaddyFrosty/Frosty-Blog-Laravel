<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'url_title',
        'author',
		"body",
		"visible"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

	public function GetVisibility() : string
	{
		return $this->getAttribute("visible");
	}

	/*
	 * Permissions.
	 */
	public static function CanCreate( User | null $user ) : bool
	{
		return true;
		if ( $user == null )
			return false;

		if ( $user->hasPermission( "create_posts" ) )
			return true;

		return false;
	}

	public function CanView( User | null $user ) : bool
	{
		if ( $this->GetVisibility() == "visible" )
			return true;

//		if ( $user->hasPermission( "view_hidden_posts" ) )
//			return true;

		return false;
	}

	public function CanEdit( User | null $user ) : bool
	{
		return true;
//		if ( $user->name == $this->author )
//			return true;

//		if ( $user->hasPermission( "edit_posts" ) )
//			return true;

//		return false;
	}

	public function CanDelete( User | null $user ) : bool
	{
		return CanEdit( $user );
	}

	/*
	 * Title Validation.
	 */
	public static function CanUseTitle( string $title ) : string | null
	{
		if ( $title == "create" )
			return "Create is a reserved title.";

		return null;
	}

	/*
	 * List all posts.
	 */
	public static function ListAllPostsCached() : Collection
	{
		return Post::select( "title", "url_title", "created_at", "author" )
				->where( "visible", "visible" )
				->orderBy( "id", "DESC" )
				->get();
	}

	/*
	 * Generate a URL title from a title.
	 */
	public static function GenerateUrlTitle( string $title ) : string
	{
		$url_title = mb_strtolower( $title );
		$url_title = str_replace( " ", "_", $url_title );

		if ( Post::where( "url_title", $url_title )->get()->isEmpty() )
			return $url_title;

		$i = 1;
		while ( true ) {
			$url_title = $url_title . "_" . $i;
			if ( Post::where( "url_title", $url_title )->get()->isEmpty() )
				return $url_title;

			$i++;
		}

//		throw new \Exception( "Failed to generate URL title." );
	}

	/*
	 * Convert a URL title to a namespace.
	 */
	public static function UrlTitleToNamespace( string $url_title ) : string
	{
		$url_title = str_replace( "_", " ", $url_title );
		$url_title = ucwords( $url_title );
		return str_replace( " ", "_", $url_title );
	}
}
