<?php

namespace Http\Middleware;

use Closure;
use Exceptions\CustomException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use User;

class AuthenticationMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($authorizationHeader = $request->header("authorization", false)) {
            $token = $this->getBearerToken($authorizationHeader);
            $user = User::where("token", $token)->firstOrFail();
            Auth::setUser($user);
            return $next($request);
        }
        throw new CustomException('',401);
    }

    function getBearerToken($authorizationHeader) {
        if (!empty($authorizationHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}
