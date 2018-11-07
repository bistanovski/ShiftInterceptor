<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\{JWTException, TokenExpiredException, 
    TokenInvalidException, InvalidClaimException,
    PayloadException, TokenBlacklistedException, UserNotDefinedException};

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try
        {
            if(null === JWTAuth::getToken())
            {
                return response()->webApi(['error' => 'token_not_provided'], 401);
            }

            if (! $user = JWTAuth::parseToken()->authenticate() )
            {
                return response()->webApi(['error' => 'user_not_found'], 401);
            }
        }
        catch (TokenExpiredException $e)
        {
            // If the token is expired, new refreshed token will be provided in the response
            try
            {
                $refreshedToken = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshedToken)->toUser();
                return response()->webApi(['refreshed_token' => $refreshedToken]);
            }
            catch (TokenBlacklistedException $e)
            {
                return response()->webApi(['error' => 'token_blacklisted'], 501);
            }
            catch (JWTException $e)
            {
                return response()->webApi(['error' => $e->getMessage()], 501);
            }
        }
        catch (JWTException $e)
        {
            return response()->webApi(['error' => $e->getMessage()], 502);
        }

        return  $next($request);
    }
}
