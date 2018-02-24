<?php
namespace App\v1\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\v1\Models\Entity\User;
use App\Lib\Helper;
/**
 * Controller de usuario
 */
class UserController {
    /**
     * Container Class
     * @var [object]
     */
    private $container;
    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container) {
        $this->container = $container;
    }
    
    /**
     * Listagem de Usuario
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function list($request, $response, $args) {
        $entityManager = $this->container->get('em');
        $user = $entityManager->getRepository('App\v1\Models\Entity\User')->findAll();
        $allUsers = $this->formatUser($users);
        $return = $response->withJson($allUsers, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;        
    }
    
    /**
     * Cria um usuario
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function create($request, $response, $args) {
        $params = (object) $request->getParams();
        $entityManager = $this->container->get('em');
        // Valida e-mail
        print_r((new Helper())->validaEmail($params->email));
        if(!(new Helper())->validaEmail($params->email)){
            throw new \Exception("E-mail inválido.", 400); 
        }
        $user = (new User())->setName($params->name)->setEmail($params->email);
        $entityManager->persist($user);
        $entityManager->flush();
        if (!$user->getId()) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuario não cadastrado");
        } 
        $retUser = array(
            'id' => $user->getId(),
        );
        $logger = $this->container->get('logger');
        $logger->info('Usuario criado', $user->getValues());
        $return = $response->withJson($retUser, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }
    /**
     * Exibe as informações de um usuario 
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function getUser(Request $request, Response $response, $args) {
        $id = (int) $args['id'];
        $entityManager = $this->container->get('em');
        $user = $entityManager->getRepository('App\v1\Models\Entity\User')->find($id);
        if (!$user) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuario {$id} não encontrado");
            throw new \Exception("Página não encontrada", 404);
        }   
        $retUser = array(
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ); 
        $return = $response->withJson($retUser, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;   
    }
    /**
     * Atualiza um usuario
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function update($request, $response, $args) {
        $id = (int) $args['id'];
        $entityManager = $this->container->get('em');
        $user = $entityManager->getRepository('App\v1\Models\Entity\User')->find($id);   
        if (!$user) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuario {$id} não encontrado");
            throw new \Exception("Página não encontrada", 404);
        }  
        $user->setName($request->getParam('name'))->setEmail($request->getParam('email'));
        $retUser = array(
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        );
        $entityManager->persist($user);
        $entityManager->flush();        
        $return = $response->withJson($retUser, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }
    /**
     * Deleta um Livro
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function delete($request, $response, $args) {
        $id = (int) $args['id'];
        $entityManager = $this->container->get('em');
        $user = $entityManager->getRepository('App\v1\Models\Entity\User')->find($id);   
        if (!$user) {
            $logger = $this->container->get('logger');
            $logger->warning("Usuário {$id} não encontrado");
            throw new \Exception("Página não encontrada", 404);
        }  
        $entityManager->remove($user);
        $entityManager->flush(); 
        $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;    
    }

    private function formatUser($array){
        $arrReturn = [];
        foreach($array AS $key => $user){
            array_push($arrReturn, array(
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ));
        }
        return $arrReturn;
    }
    
}