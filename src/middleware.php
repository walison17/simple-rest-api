<?php

if (config('debug')) {
    $app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app));
}
