<?php

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

/** @var array */
$settings = require __DIR__ . '/settings.php';

/** @var Container */
$container = Tuiter\Core\Container::instance($settings);

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $status = $exception->getCode() ?: 500;
        $body = $exception instanceof \Tuiter\Core\Exceptions\ValidationException
            ? $exception
            : ['message' => $exception->getMessage()]; 
        return $c['response']
            ->withStatus($status)
            ->withJson($body);
    };
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) {
        return $response->withStatus(404);
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) {
        return $response->withStatus(405);
    };
};

/** @var Slim */
$app = new \Slim\App($container);

date_default_timezone_set('America/Recife');

require __DIR__ . '/dependencies.php';

require __DIR__ . '/middleware.php';

require __DIR__ . '/routes.php';


Respect\Validation\Validator::with('Tuiter\Core\\Validation\\Rules\\');
