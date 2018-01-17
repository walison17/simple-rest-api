<?php

namespace TuiterMiddlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        return auth('jwt')->check() ? $next($request, $response) : redirect('auth.showForm');
    }
}