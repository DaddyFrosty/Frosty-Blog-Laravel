<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Utility
{
	//-----------------------------------------------------------------------------
	//
	// Purpose: GenerateGuid, Random Guid.
	// Purpose: GetUniqueGuid, to make sure we have a unique key
	// Purpose: CurTime, for time keeping purposes, returns time in UTC.
	// Purpose: GetIP, for Authentication.
	// Purpose: IsValidImage, check if the image is valid
	//
	//-----------------------------------------------------------------------------
	public static function GenerateGuid() : string
	{
		return Str::uuid();
	}

	public static function GetUniqueGuid( $table, $column ) : string
	{
//		$generatedKey = Utility::RandomString($len);
//		$result = DB::table($table)->where($column, $generatedKey)->get();
//		if (!$result->isEmpty()) { return Utility::getUniqueKey($len, $table, $column); }
//		return $generatedKey;

		while ( true )
		{
			$guid = Utility::GenerateGuid();
			$result = DB::table( $table )->where( $column, $guid )->get();
			if ( $result->isEmpty() )
			{
				return $guid;
			}
		}
	}

	public static function CurTime() : int
	{
		// Just to be safe.
//		date_default_timezone_set("UTC");
//		return date( "U" );
		return time();
	}

	public static function GetIP( Request $request ) : string
	{
		return $request->ip();
	}

	public static function IsValidImage( Array $imageData ) : bool // $imageData as Byte Array
	{
		return true;
	}
}
