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
}
