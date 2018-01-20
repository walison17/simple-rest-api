<?php

namespace TuiterMiddlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class GuestMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        return auth('jwt')->check() ? redirect('home') : $next($request, $response);
    }
}