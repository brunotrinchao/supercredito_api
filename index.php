<?
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './configs.php';

require __DIR__ . '/dependencies.php';
// require __DIR__ . '/middlewhere.php';
require __DIR__ . '/routes.php';
$app->run();

// /**
//  * Bootstrap da API
//  */
// require './bootstrap.php';
// /**
//  * Rotas da API
//  */
// require './router.php';
// $app->run();



