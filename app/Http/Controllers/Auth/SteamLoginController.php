<?php

namespace App\Http\Controllers\Auth;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use kanalumaddela\LaravelSteamLogin\Http\Controllers\AbstractSteamLoginController;
use kanalumaddela\LaravelSteamLogin\SteamUser;
class SteamLoginController extends AbstractSteamLoginController
{
	/**
	 * {@inheritdoc}
	 */
	public function authenticated( Request $request, SteamUser $steamUser )
	{
        $user = User::GetUserBySteamId64( $steamUser->steamId );
        $steamUser->getUserInfo();

        if ( $user )
        {
            if ( $user->steam_name != $steamUser->name )
            {
                $user->steam_name = $steamUser->name;
//                $user->save();
            }
        }
        else
        {
            // Create a new user
            $uid = User::GenerateGuid();
            $user = User::create( [
                "uid" => $uid,
                "steam_name" => $steamUser->name,
                "avatar" => User::GetRandomIdenticonUrl( $uid, $steamUser->steamId ),
                "permission_id" => Permission::DefaultRoleId(),
                "steamid64" => $steamUser->steamId,
            ] );
        }

        $user->touch();
        $user->UpdateCache();
        Auth::login( $user, true );
	}

	public function Logout( Request $request )
	{
		Auth::logout();
		return $this->steam->previousPage();
	}
}
