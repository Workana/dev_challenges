<?php
declare(strict_types=1);

use App\Application\Exceptions\ExceptionHandler;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'./../');
$dotenv->load();

$builder = new \DI\ContainerBuilder();
$definitions = require __DIR__ . '/../app/Config/definitions.php';
$builder->addDefinitions($definitions);

$container = $builder->build();

AppFactory::setContainer($container);
$settings = require __DIR__ . '/../app/Config/settings.php';
$settings($container);

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = new ExceptionHandler($app->getCallableResolver(), $app->getResponseFactory());
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);
$app->run();

