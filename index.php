<?

// $app = new Slim\App($configSlim);

// require __DIR__ . '/dependencies.php';
// require __DIR__ . '/middlewhere.php';
// require __DIR__ . '/routes.php';
// $app->run();

/**
 * Bootstrap da API
 */
require './bootstrap.php';
/**
 * Rotas da API
 */
require './routes.php';
$app->run();



