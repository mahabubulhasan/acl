<?php

namespace Uzzal\Acl\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Uzzal\Acl\Services\PermissionCheckService;
use Route;

class AuthenticateWithAcl {

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|Response|mixed|\Symfony\Component\HttpFoundation\Response
     */
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
