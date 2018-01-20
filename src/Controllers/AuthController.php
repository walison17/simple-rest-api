<?php 

namespace Tuiter\Controllers;

use Firebase\JWT\JWT;
use Tuiter\Core\Http;
use Slim\Http\Request;
use Slim\Http\Response;
use League\Fractal\Resource\Item;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthController extends BaseController
{
    public function signIn(RequestInterface $request, ResponseInterface $response)
    {   
        $user = auth('jwt')
            ->authenticate([
                'email' => request('email'), 
                'password' => request('password')
            ]);  
        
        $token = [
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "sub" => $user->getId() 
        ];

        $jwt = JWT::encode($token, config('jwt_key'));

        return json(['token' => $jwt]);
    }   

    /**
     * Retorna os detalhes do usuário logado
     *
     * @return \Slim\Http\Response
     */
    public function getUserDetails(Request $request, Response $response)
    {
        if (! auth('jwt')->check()) {
            return $response->withStatus(Http::UNAUTHORIZED);
        }

        $fractal = app('fractal');
        $transformer = app('user.transformer');
        $resource = new Item(auth('jwt')->getCurrentUser(), $transformer);

        return json($fractal->createData($resource)->toArray(), Http::OK);
    }
}