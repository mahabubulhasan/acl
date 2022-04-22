<?php

namespace Uzzal\Acl\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Uzzal\Acl\Services\PermissionCheckService;
use Illuminate\Support\Facades\Route;

class AuthenticateWithAcl {

    protected $auth;

    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next) {
        if($this->auth->guest()){
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if(!PermissionCheckService::canAccess(Route::currentRouteAction(), $this->auth->user())){
            return new Response('Forbidden', 403);
        }
                        
        return $next($request);
    }
    
}
