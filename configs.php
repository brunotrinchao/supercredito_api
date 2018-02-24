<?

if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false) {
    define('PHP_TIMEZONE', 'America/Bahia');
    define('SECURITY_SERVERSLIM', true);
}
date_default_timezone_set(PHP_TIMEZONE);
header('Content-Type: text/html; charset=utf-8');

// JWT key
define('JWT_KEY', 'G%cf0a2E*Hr1KYyMwrbF*08oYRs@sZiB^q7x7Vty5R4ZW7%3jR');

define('LIMIT', 50);

// Códigos extraidos do Livro "Desenvolvendo APIs que você não odiará"
// 200 - Genérico para tudo que está ok
// 201 - Algo foi criado
// 202 - Aceito e sendo processado assincronamente (codificação de vídeos, redimensionamento de imagens e etc)
// 400 - Argumentos errados (validação ausente)
// 401 - Não autorizado (deve existir um usuário atual)
// 403 - Usuário atual não autorizado a acessar esta informação
// 404 - A URL não é uma rota válida ou o recurso solicitado não existe
// 410 - A informação foi excluída, desativada, suspensa e etc
// 500 - Algo inesperado aconteceu e é culpa da API
// 503 - API indisponível no momento, por favor tente mais tarde

define('HC_SUCCESS', 200);
define('HC_SUCCESS_CREATED', 201);
define('HC_SUCCESS_ASYNC', 202);
define('HC_SUCCESS_NOCONTENT', 204);
define('HC_ERROR_ARGUMENTS', 400);
define('HC_ERROR_NOTALLOW', 401);
define('HC_ERROR_NOTALLOWINFO', 403);
define('HC_ERROR_NOTEXISTS', 404);
define('HC_ERROR_REMOVED', 410);
define('HC_API_ERROR', 500);
define('HC_API_OFF', 503);
