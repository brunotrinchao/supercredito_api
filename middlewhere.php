<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr7Middlewares\Middleware\TrailingSlash;
use Monolog\Logger;
use Firebase\JWT\JWT;

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
// $app->add(new \Slim\Middleware\JwtAuthentication([
//     "header" => "Authorization",
//     "path" => ["/"],
//     "passthrough" => ["/v1/publica", "/auth"],
//     "secret" => JWT_KEY,
//     "callback" => function (Request $request, Response $response, $arguments) use ($container) {
//         $container["user"] = json_decode(json_encode($arguments["decoded"]), true);
//     },
//     "secure" => SECURITY_SERVERSLIM,
//     "relaxed" => ["localhost"],
//     "error" => function (Request $request, Response $response, $arguments) {
//         $data["status"] = "error";
//         $data["message"] = $arguments["message"];
//         return $response
//             ->withHeader("Content-Type", "application/json")
//             ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
//     }
// ]));