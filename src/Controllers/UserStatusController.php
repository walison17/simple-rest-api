<?php

namespace Tuiter\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Tuiter\Models\Status;

class UserStatusController extends BaseController
{
    private $repository;
    private $transformer;
    private $fractal;

    public function __construct()
    {   
    }

    public function new(Request $request, Response $response, array $args)
    {
        $user = $this->userRepository->getByUsername($args['username']);
        $status = new Status;
        $status->setUser($user)
            ->setText();

        $this->statusRepository->save($status);

        return json();
    }
}