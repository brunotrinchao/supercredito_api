<?php
namespace App\Administracao;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/**
 * Controller de Autenticação
 */
final class AuthController {
    /**
     * Container
     * @var object s
     */
   protected $container;
   
   /**
    * Undocumented function
    * @param ContainerInterface $container
    */
   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }
   
   /**
    * Invokable Method
    * @param Request $request
    * @param Response $response
    * @param [type] $args
    * @return void
    */
   public function __invoke(Request $request, Response $response, $args) {
    /**
     * JWT Key
     */
    // $key = $this->container->get("secretkey");
    // $token = array(
    //     "user" => "@fidelissauro",
    //     "twitter" => "https://twitter.com/fidelissauro",
    //     "github" => "https://github.com/msfidelis"
    // );
    // $jwt = JWT::encode($token, $key);
    // return $response->withJson(["auth-jwt" => $jwt], 200)
    //     ->withHeader('Content-type', 'application/json');  
    return $response; 
   }
}