<?php

namespace App\Administracao;

use Slim\Container;
use Lib\PDOHelpers;
use Lib\Model;

class Parceiro extends Model
{
    protected $table = 'vw_adm_parceiro';
    protected $defaultSort = 'id';

    protected $searchBy = [
        'id' => 'par_int_codigo',
        'nome' => 'par_var_nome'
    ];

    public function select()
    {
        $query = "SELECT par_int_codigo as id,
                         par_var_nome as nome,
                         par_var_token as token,
                         par_cha_status as status_id,
                         par_var_status as status_nome,
                    FROM " . $this->table;

        $query .= $this->filter->getWhere();
        return $this->execute($query);
    }
}