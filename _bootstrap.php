<?

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Psr7Middlewares\Middleware\TrailingSlash;
use Monolog\Logger;
use Firebase\JWT\JWT;
/**
 * Configurações
 */
$configs = [
    'settings' => [
        'displayErrorDetails' => true,
    ]   
];
/**
 * Container Resources do Slim.
 * Aqui dentro dele vamos carregar todas as dependências
 * da nossa aplicação que vão ser consumidas durante a execução
 * da nossa API
 */
$container = new \Slim\Container($configs);
/**
 * Converte os Exceptions Genéricas dentro da Aplicação em respostas JSON
 */
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        return $container['response']->withStatus($statusCode)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};
/**
 * Converte os Exceptions de Erros 405 - Not Allowed
 */
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $container['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};
/**
 * Converte os Exceptions de Erros 404 - Not Found
 */
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(['message' => 'Page not found']);
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
$isDevMode = true;

$paths = array(__DIR__."/src/App");

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
            'dbname' => 'supercredito_db',
			'user' => 'root',
			'password' => '',
			'host' => '127.0.0.1',
			'driver' => 'pdo_mysql'
        );
// obtaining the entity manager
/**
 * Instância do Entity Manager
 */
$entityManager = EntityManager::create($conn, $config);

/**
 * Coloca o Entity manager dentro do container com o nome de em (Entity Manager)
 */
$container['em'] = $entityManager;
/**
 * Token do nosso JWT
 */
$container['secretkey'] = JWT_KEY;
/**
 * Application Instance
 */
$app = new \Slim\App($container);
/**
 * @Middleware Tratamento da / do Request 
 * true - Adiciona a / no final da URL
 * false - Remove a / no final da URL
 */
$app->add(new TrailingSlash(false));
/**
 * Auth básica HTTP
 */
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
/**
 * Auth básica do JWT
 * Whitelist - Bloqueia tudo, e só libera os
 * itens dentro do "passthrough"
 */
$app->add(new \Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/",
    "header" => "Authorization",
    "path" => "/",
    "passthrough" => ["/auth"],
    "realm" => "Protected",
    "secret" => JWT_KEY
]));
/**
 * Proxys confiáveis
 */
// $trustedProxies = ['0.0.0.0', '127.0.0.1'];
// $app->add(new RKA\Middleware\SchemeAndHost($trustedProxies));

// $app->add(new \Slim\Middleware\JwtAuthentication([
//     "header" => "Authorization",
//     "path" => ["/"],
//     "passthrough" => ["publica"],
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