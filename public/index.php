<?php

namespace App;

use Zend\Expressive\Application;
use Zend\Expressive\Helper;

// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

/** @var \Zend\Expressive\Application $app */
$app = $container->get(Application::class);

// Create pipeline
$app->pipe(Helper\ServerUrlMiddleware::class);
$app->pipe(Middleware\TheClacksMiddleware::class);
$app->pipe(Middleware\UuidMiddleware::class);
$app->pipe(Middleware\RequestTimeMiddleware::class);

$app->pipeRoutingMiddleware();
$app->pipe(Helper\UrlHelperMiddleware::class);
$app->pipeDispatchMiddleware();

// Add routed middleware
$app->get('/', Action\HomePageAction::class, 'home');
$app->get('/api/ping', Action\PingAction::class, 'api.ping');
$app->get('/page/[{action}]', Action\PageAction::class, 'page');
$app->get('/users', Action\UserListAction::class, 'user.list');
$app->get('/users/dbal', Action\UserDbalListAction::class, 'user.dbal.list');

$app->run();
