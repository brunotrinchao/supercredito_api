<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr7Middlewares\Middleware\TrailingSlash;
use Monolog\Logger;
use Firebase\JWT\JWT;

$configs = [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'db' => [
            'MYSQL_HOST' => $_SERVER['MYSQL_HOST'],
            'MYSQL_HOST_READ' => (empty($_SERVER['MYSQL_HOST_READ']) ? $_SERVER['MYSQL_HOST'] : $_SERVER['MYSQL_HOST_READ']),
            'MYSQL_PORT' => $_SERVER['MYSQL_PORT'],
            'MYSQL_USER' => $_SERVER['MYSQL_USER'],
            'MYSQL_PASS' => $_SERVER['MYSQL_PASS'],
            'MYSQL_BASE' => $_SERVER['MYSQL_BASE'],
            'MYSQL_CHARSET' => $_SERVER['MYSQL_CHARSET'],
            'MYSQL_TIMEZONE' => $_SERVER['MYSQL_TIMEZONE']
        ],
        'pagination' => [
            'default_per_page' => 20,
            'max_per_page' => 100,
        ],
        'timezone' => '-03:00'
    ]
];

$container = new \Slim\Container($configs);

$container['secretkey'] = JWT_KEY;
/**
 * Coloca na "globals" a conexão e o objeto do usuário
 */
$container['pdo'] = function ($c) {
    try {
        return new \Lib\Connection($c);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
};

$container['user'] = function ($container) {
    return new StdClass;
};

$container['sanitize'] = function () {
    return function ($fields) {
        return $fields = \Lib\Sanitize::filter($fields);
    };
};



/**
 * Serviço de Logging em Arquivo
 */
// TODO - Alterar o nome do log para o dia atual
$container['logger'] = function($container) {
    $logger = new Monolog\Logger('api-log');
    $logfile = __DIR__ . '/log/api-log.log';
    $stream = new Monolog\Handler\StreamHandler($logfile, Monolog\Logger::DEBUG);
    $fingersCrossed = new Monolog\Handler\FingersCrossedHandler(
        $stream, Monolog\Logger::INFO);
    $logger->pushHandler($fingersCrossed);
    
    return $logger;
};

$app = new \Slim\App($container);

$app->add(new TrailingSlash(false));

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    /**
     * Usuários existentes
     */
    "users" => [
        "root" => "toor"
    ],
    /**
     * Blacklist - Deixa todas liberadas e só protege as dentro do array
     */
    "path" => ["/auth"],
    /**
     * Whitelist - Protege todas as rotas e só libera as de dentro do array
     */
    //"passthrough" => ["/auth/liberada", "/admin/ping"],
]));

//JWT AUTH
$app->add(new \Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/",
    "header" => "Authorization",
    "path" => "/",
    "passthrough" => ["/auth"],
    "realm" => "Protected",
    "secret" => JWT_KEY
]));

