<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NeedsPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle( Request $request, Closure $next, ...$reqPermsStr )
    {
//		dd($reqPermsStr);
		return $next($request);
//		return app( Authenticate::class )->handle( $request, function( $request ) use ( &$next, &reqPermsStr ) {
//			foreach ($permission as $i => $permission) {
//				if (!Auth::user()->hasPermission($permission)) { abort(403, 'Insufficient Permissions | ' . $permission); return; }
//			}
//
//			$requiredPermissions = explode( '|', $permission );
//
//			return $next($request);
//		});
    }
}
