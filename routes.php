<?
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
/**
 * Grupo dos enpoints iniciados por v1
 */
$app->group('/v1', function() {
    // Usuario
    $this->group('/usuario', function() {
        $this->get('', \App\v1\Controllers\UsuarioController::class . ':listar');
        $this->post('', \App\v1\Controllers\UsuarioController::class . ':create');
    });

    // // Usuário
    // $this->group('/usuario', function() {
    //     $this->get('', \App\v1\Controllers\UsuarioController::class . ':list');
    //     $this->get('/{id:[0-9]+}',  \App\v1\Controllers\UsuarioController::class . ':getUser');
    //     $this->post('',  \App\v1\Controllers\UsuarioController::class . ':create');
    //     $this->put('/{id:[0-9]+}',  \App\v1\Controllers\UsuarioController::class . ':update');
    //     $this->delete('/{id:[0-9]+}',  \App\v1\Controllers\UsuarioController::class . ':delete');
    // });

    $this->group('/auth', function() {
        $this->get('', \App\v1\Administracao\AuthController::class);
    });

});





