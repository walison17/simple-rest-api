<?php 

namespace Tuiter\Controllers;

use Tuiter\Core\Http;
use Slim\Http\Request;
use Slim\Http\Response;
use Tuiter\Models\User;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Tuiter\Core\Validation\Validator;
use Tuiter\Db\UserRepositoryInterface;
use Respect\Validation\Validator as v;
use League\Fractal\Resource\Collection;
use Tuiter\Models\Transformers\UserTransformer;
use Tuiter\Core\Exceptions\ValidationException;

class UsersController extends BaseController
{
    /** @var UserRepositoryInterface */
    private $repository;

    /** @var \League\Fractal\Manager */
    private $fractal;

    /** @var UserTransformer */
    private $transformer;

    public function __construct(
        UserRepositoryInterface $repository,
        UserTransformer $transformer, 
        Manager $fractal    
    )
    {
        $this->repository = $repository;
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    /**
     * Retorna todos usuários
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args)
    {
        $users = $this->repository->getAll();
        $resource = new Collection($users, $this->transformer);
        
        return json($this->fractal->createData($resource)->toArray(), Http::OK);
    }

    /**
     * Adiciona um novo usuário
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function new(Request $request, Response $response, array $args)
    {
        $validator = new Validator;

        $validator->validate($request->getParams(), [
            'username' => v::notOptional()->noWhitespace(),
            'email' => v::notOptional()->email()->emailAvailable(),
            'password' => v::notOptional()->alnum()->noWhitespace()->length(8, 16)
        ]);

        if ($validator->fail()) {   
            throw new ValidationException($validator->getMessages());
        }

        $user = new User;
        $user->setUsername($request->getParam('username'))
            ->setEmail($request->getParam('email'))
            ->setPassword(password_hash($request->getParam('password'), PASSWORD_BCRYPT));

        $this->repository->save($user);

        return $response->withStatus(Http::CREATED);
    }

    /**
     * Detalha um usuário
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function show(Request $request, Response $response, array $args)
    {
        $user = $this->repository->getByUsername($args['user']);    
        
        if (! $user) {
            return $response->withStatus(Http::NOT_FOUND);
        }

        $resource = new Item($user, $this->transformer);

        return json($this->fractal->createData($resource)->toArray(), Http::OK);
    }

    /**
     * Deleta um usuário
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Slim\Http\Response
     */
    public function destroy(Request $request, Response $response, array $args)
    {
        if (! auth('jwt')->check()) {
            return $response->withStatus(Http::UNAUTHORIZED);
        }

        $user = $this->repository->getByUsername($args['user']);

        if (! $user || ! $user->equals(auth('jwt')->getCurrentUser())) {
            return $response->withStatus(Http::NOT_FOUND);
        }

        $this->repository->delete($user);

        return $response->withStatus(Http::NO_CONTENT);
    }
}