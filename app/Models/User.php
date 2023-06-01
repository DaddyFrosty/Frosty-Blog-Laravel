<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Structs\CacheInfo;
use App\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

	protected static CacheInfo $CacheUser;

	public static function Init()
	{
		User::$CacheUser = new CacheInfo( "user_", 3600 * 2 );
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'name',
        'avatar',
		'permission_id',
		'steamid64',
		'steam_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'permission_id',
		'id',
		'steam_name'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'steamid64' => 'string',
    ];

	/*
	 * Permission relationship.
	 */
//	public function permissions()
//	{
////		return $this->hasOne( Permission::class, 'id', 'permission_id' );
//		return $this->belongsTo( Permission::class, 'id', 'permission_id' );
//	}

	protected function getPermissionsAttribute() : Permission
	{
		if ( $this->relationLoaded( "permission" ) )
			return $this->getRelationValue( "permission" );

		$permission = Permission::GetCachedGroup( $this->permission_id );
//		dd($this->permission_id, $permission);

		$this->setRelation( "permission", $permission );
		return $permission;
	}

	public function HasPermission( string $permission ) : bool
	{
		return $this->permissions->HasPermission( $permission );
	}

	/*
	 * Returns a gravatar URL for the user.
	 */
	protected static bool $UseSteamIdForAvatar = false;
	public static function GetRandomIdenticonUrl( string $userGuid, string $userSteamId, int $size = 256 ) : string
	{
		$uId = User::$UseSteamIdForAvatar
			? mb_strlen( $userSteamId ) > 0 ? $userSteamId : $userGuid
			: $userGuid;
		return 'https://www.gravatar.com/avatar/' . $uId . '?d=identicon&s=' . $size;
	}

	/*
	 * Generate a random unique GUID.
	 */
	public static function GenerateGuid() : string
	{
		return Utility::GetUniqueGuid( 'users', 'uid' );
	}

	/*
	 * Name Helpers.
	 */
	public function GetName() : string
	{
		return mb_strlen( $this->name ) == 0 ? $this->steam_name : $this->name;
	}

	public function GetColor() : array
	{
		return $this->permissions->color;
	}

	/*
	 * NO CACHING
	 */
	public static function GetUser( string $userGuid ) : User | null
	{
		return User::where( 'uid', $userGuid )->first();
	}

	public static function GetUserBySteamId64( string $steamId ) : User | null
	{
		return User::where( 'steamid64', $steamId )->first();
	}

	/*
	 * CACHING
	 */
	public static function GetCachedUser( string $userGuid ) : User | null
	{
		return Cache::remember( User::$CacheUser->Key . $userGuid, User::$CacheUser->Time,
		function () use ( $userGuid ) {
			return User::GetUser( $userGuid );
		} );
	}

	public function UpdateCache() : void
	{
		Cache::set( User::$CacheUser->Key . $this->uid, $this, User::$CacheUser->Time );
	}

	public static function FlushUserCache( string $userGuid ) : void
	{
		if ( Cache::has( User::$CacheUser->Key . $userGuid ) )
			Cache::forget( User::$CacheUser->Key . $userGuid );
	}

	public static function FlushCache() : void
	{
		$users = User::select( "uid" )->get();
		foreach ( $users as $user )
			User::FlushUserCache( $user->uid );
	}
}

User::Init();
