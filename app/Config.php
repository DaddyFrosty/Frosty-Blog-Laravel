<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class Config
{
	public static string $DateFormattingString = "j F Y H:i"; // "%-d %B %Y %H:%M";
	public static int $SidebarPostTitleMaxLength = 25;
}
