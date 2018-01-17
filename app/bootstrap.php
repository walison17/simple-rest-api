<?php

use Respect\Validation\Validator as v;

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

/** @var Slim */
$app = new \Slim\App($container);

date_default_timezone_set('America/Recife');

require __DIR__ . '/dependencies.php';

require __DIR__ . '/middleware.php';

require __DIR__ . '/routes.php';

v::with('Tuiter\Core\\Validation\\Rules\\');