<?php 

namespace Tuiter\Controllers;

use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthController extends BaseController
{
    public function getToken(RequestInterface $request, ResponseInterface $response)
    {   
        $user = auth('jwt')->authenticate(['email' => request('email'), 'password' => request('password')]);  
        
        $token = [
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "id" => $user->getId() 
        ];

        $jwt = JWT::encode($token, config('jwt_key'));

        return json(['token' => $jwt]);
    }   

    public function getUserDetails()
    {
        return json(auth('jwt')->getCurrentUser());
    }
}