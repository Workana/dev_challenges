<?php
declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$settings = require __DIR__ . '/../app/Config/settings.php';
$settings($container);

$app = AppFactory::create();

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);
$app->run();

