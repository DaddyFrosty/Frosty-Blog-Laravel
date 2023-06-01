<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

use App\Structs\CacheInfo;

class Post extends Model
{
    use HasFactory;

	protected static CacheInfo $CachePostsList;
	protected static CacheInfo $CachePost;

	public static function Init()
	{
		Post::$CachePostsList = new CacheInfo( "posts_list", 3600 * 12 );
		Post::$CachePost = new CacheInfo( "post_", 3600 * 12 );
	}

	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'url_title',
        'author_uid',
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

	/*
	 * Author relationship.
	 */
//	public function author() : BelongsTo
//	{
//		return $this->belongsTo( User::class, 'author_uid', 'uid' );
//	}

	protected function getAuthorAttribute() : User
	{
		if ( $this->relationLoaded( "author" ) )
			return $this->getRelationValue( "author" );

		$author = User::GetCachedUser( $this->author_uid );

		$this->setRelation( "author", $author );
		return $author;
	}

	public function GetVisibility() : string
	{
		return $this->getAttribute("visible");
	}

	public function SetVisibility( string $visibility ) : void
	{
		$this->setAttribute( "visible", $visibility );
	}

	/*
	 * Permissions.
	 */
	public static function CanCreate( User | null $user ) : bool
	{
		if ( $user == null )
			return false;

		if ( $user->HasPermission( "POST_CREATE" ) )
			return true;

		return false;
	}

	public function CanView( User | null $user ) : bool
	{
		if ( $this->GetVisibility() == "visible" )
			return true;

		if ( $user && $user->HasPermission( "POST_VIEW_HIDDEN" ) )
			return true;

		return false;
	}

	public function CanEdit( User | null $user ) : bool
	{
		if ( $user == null )
			return false;

		if ( $user->name == $this->author && $user->HasPermission( "POST_EDIT_OWN" ) )
			return true;

		if ( $user->HasPermission( "POST_EDIT_OTHERS" ) )
			return true;

		return false;
	}

	public function CanDelete( User | null $user ) : bool
	{
		if ( $user == null )
			return false;

		if ( $user->name == $this->author && $user->HasPermission( "POST_DELETE_OWN" ) )
			return true;

		if ( $user->HasPermission( "POST_DELETE_OTHERS" ) )
			return true;

		return false;
	}

	public static function CanClearCache( User | null $user ) : bool
	{
		if ( $user == null )
			return false;

		return $user->HasPermission( "POST_CLEAR_CACHE" );
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
	 * Generate a URL title from a title.
	 */
	public static array $ReplaceCharactersWithUnderscore = [
		" ", ",", "\"", "/", "\\", ".", ":", ";",
		"!", "@", "#", "$", "%", "^", "&", "*",
		"(", ")", "+", "=", "{", "}", "[", "]",
		"|", "?", "<", ">", "~", "`", "'", "\"",
		"“", "”", "’", "‘", "–", "—", "…", "•",
	];

	public static string $NonANSILettersAndNumberRegex = '/[\x00-\x2F|\x3A-\x40|\x5B-\x5E|\x60|\x7B-\xFF]/u';

	public static function GenerateUrlTitle( string $title ) : string
	{
		$url_title = mb_strtolower( $title );
		$url_title = str_replace( Post::$ReplaceCharactersWithUnderscore, "_", $url_title );
		$url_title = preg_replace( Post::$NonANSILettersAndNumberRegex, "", $url_title );
		$url_title = preg_replace( '/_{2,}/', "_", $url_title );

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

	/*
	 * UNCACHED - Get Post.
	 */
	public static function GetPost( int $postId ) : Post | null
	{
		return Post::where( "id", $postId )->first();
	}

	/*
	 * Cached - Get Post.
	 */
	public static function GetCachedPost( int $postId ) : Post | null
	{
		return Cache::remember( Post::$CachePost->Key . $postId, Post::$CachePost->Time,
		function() use ( $postId ) {
			return Post::GetPost( $postId );
		} );
	}

	public static function FlushPostCache( int $postId ) : void
	{
		if ( Cache::has( Post::$CachePost->Key . $postId ) )
			Cache::forget( Post::$CachePost->Key . $postId );
	}

	public function FlushCached()
	{
		Post::FlushPostCache( $this->id );
	}

	/*
	 * List all posts.
	 */
	public static function ListAllPostsCached() : Collection
	{
		return Cache::remember( Post::$CachePostsList->Key, Post::$CachePostsList->Time, function() {
			return Post::select( "title", "url_title", "created_at", "author_uid" )
				->where( "visible", "visible" )
				->orderBy( "id", "DESC" )
				->get();
		} );
	}

	public function UpdateCache() : void
	{
		Post::FlushListCache();
		Cache::set( Post::$CachePost->Key . $this->id, $this, Post::$CachePost->Time );
	}

	public static function FlushListCache() : void
	{
		if ( Cache::has( Post::$CachePostsList->Key ) )
			Cache::forget( Post::$CachePostsList->Key );
	}

	/*
	 * Flush all caches.
	 * Including individual posts.
	 */
	public static function FlushCache() : void
	{
		Post::FlushListCache();
		$posts = Post::select( "id" )->get();
		foreach ( $posts as $post )
			Post::FlushPostCache( $post->id );
	}
}

Post::Init();
