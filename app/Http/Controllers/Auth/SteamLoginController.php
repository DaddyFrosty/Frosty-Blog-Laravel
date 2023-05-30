<?php

namespace App\Http\Controllers\Auth;

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
		dd( $steamUser );
	}

	public function Logout( Request $request )
	{
		Auth::logout();

		return $this->steam->previousPage();
	}
}
