<?php

namespace App\Models;

use App\Structs\CacheInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Permission extends Model
{
    use HasFactory;

	protected static CacheInfo $CachePermissions;

	public static function Init()
	{
		Permission::$CachePermissions = new CacheInfo( "permission_", 3600 * 12 );
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'color',
		'permissions',
		'default',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
//		'default',
//		'id'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'permissions' => 'array',
		'default' => 'boolean',
		'color' => 'array',
	];

	/*
	 * Permission Helpers.
	 */
	public function HasPermission( string $permissionId ) : bool
	{
		if ( isset( $this->permissions["*"] ) )
			return true;

//		return array_key_exists( $permissionId, $this->permissions );
		return isset( $this->permissions[$permissionId] ) && $this->permissions[$permissionId];
	}

	public static function DefaultRoleId() : int
	{
		return Permission::where( "default", true )->first()->id;
	}

	/*
	 * UNCACHED
	 */
	public static function GetGroup( int $permissionId ) : Permission | null
	{
		return Permission::where( "id", $permissionId )->first();
	}

	/*
	 * CACHING
	 */
	public static function GetCachedGroup( int $permissionId ) : Permission | null
	{
		return Cache::remember( Permission::$CachePermissions->Key . $permissionId, Permission::$CachePermissions->Time,
		function() use ( $permissionId ) {
			return Permission::GetGroup( $permissionId );
		} );
	}

	public function UpdateCache() : void
	{
		Cache::set( Permission::$CachePermissions->Key . $this->id, $this, Permission::$CachePermissions->Time );
	}

	public static function FlushGroupCache( int $permissionId ) : void
	{
		if ( Cache::has( Permission::$CachePermissions->Key . $permissionId ) )
			Cache::forget( Permission::$CachePermissions->Key . $permissionId );
	}

	public static function FlushCache() : void
	{
		$groups = Permission::select( "id" )->get();
		foreach ( $groups as $group )
			Permission::FlushGroupCache( $group->id );
	}
}

Permission::Init();
