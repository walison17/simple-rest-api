<?php

$container['logger'] = function () {
    $logger = new Monolog\Logger(config('logger.name'));
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler(config('logger.path'), config('logger.level')));

    return $logger;
};  

$container['user.repository'] = function ($container) {
    $connection = \Tuiter\Db\Connection\ConnectionFactory::create();
    
    return new \Tuiter\Db\UserRepository($connection);
};

$container['auth.jwt'] = function ($container) {
    $provider = new \Tuiter\Core\Auth\Providers\JwtProvider($container['user.repository'], $container['request']);

    return new \Tuiter\Core\Auth\Authenticator($provider);
};

$container['registration.controller'] = function ($c) {
    return new \Tuiter\Controllers\RegistrationController($c['user.repository']);
};

$container['AuthController'] = function ($c) {
    return new \Tuiter\Controllers\AuthController($c);
};

$container['user.transformer'] = function ($c) {
    return new \Tuiter\Models\Transformers\UserTransformer;
};

$container['fractal'] = function ($c) {
    return new \League\Fractal\Manager;
};

$container['UsersController'] = function ($c) {
    return new \Tuiter\Controllers\UsersController(
        $c['user.repository'], 
        new \Tuiter\Models\Transformers\UserTransformer,
        new \League\Fractal\Manager
    );
};