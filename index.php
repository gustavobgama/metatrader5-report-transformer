<?php declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use GustavoGama\MetatraderReportTransformer\Http\Controllers\PositionController;
use GustavoGama\MetatraderReportTransformer\Http\Middlewares\Cors;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Strategy\JsonStrategy;
use League\Route\Router;

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);
$responseFactory = new ResponseFactory();

$router = new Router();
$router->middleware(new Cors());
$router->setStrategy(new JsonStrategy($responseFactory));
$router->map('GET', '/', $container->get(PositionController::class));

$response = $router->dispatch($request);

(new SapiEmitter)->emit($response);