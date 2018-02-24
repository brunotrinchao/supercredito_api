<?php

namespace App\Administracao;

use Lib\Controller;
use Lib\Helpers;
use Slim\Http\Request;
use Slim\Http\Response;

final class ParceirosController extends Controller
{
    private function formataDados($result)
    {
        $ret = [];

        if (count($result) > 0) {
            foreach ($result as $row) {
                $ret[] = [
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'token' => $row['token'],
                    'status' => [
                        'id' => $row['status_id'],
                        'nome' => $row['status_nome']
                    ]
                ];
            }
        }

        return $ret;
    }

    /**
     * @param Request $request
     * @return Parceiro
     */
    private function getModel(Request $request)
    {
        $configParams = [
            'queryParams' => $request->getQueryParams(),
            'readReplica' => $request->isGet()
        ];

        return new Parceiro($this->app, $configParams);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
    */
    public function listar(Request $request, Response $response)
    {
        echo 'ok';
        // $id = $request->getAttribute('route')->getArgument('id');

        // $Ambiente = $this->getModel($request);

        // if (empty($id)) {
        //     $count = $Ambiente->filtrar()->count();
        //     $ret['_links'] = $this->setPagination($Ambiente, $count, $request);
        // }

        // $result = $Ambiente->filtrar($id)->select();

        // $ret['data'] = $this->formataDados($result);
        // $ret['code'] = HC_SUCCESS;
        // return $response->withJson($ret)->withStatus($ret['code']);
    }
}