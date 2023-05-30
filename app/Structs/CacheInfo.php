<?php

namespace App\Structs;

class CacheInfo
{
	public string $Key;
	public int $Time;

	public function __construct( string $key, int $time )
	{
		$this->Key = $key;
		$this->Time = $time;
	}
}
