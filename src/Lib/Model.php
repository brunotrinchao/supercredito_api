<?php
/**
 * Classe responsavel por criar filtros de consulta a partir dos dados da Request
 *
 * User: tarsis
 * Date: 05/04/17
 * Time: 17:11
 */

namespace Lib;

use Slim\Container;
use Lib\Pagination;
use Lib\PDOFilter;

class Model
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \PDOFilter
     */
    protected $filter;


    /**
     * @var String | nome da tabela da entidade
     */
    protected $table;

    /**
     * @var null | String Ordenar este campo por padrao
     */
    protected $defaultSort = null;

    /**
     * Campos de busca
     * <code>
     * $array = [
     *   'nome_campo_na_api' => 'nome_campo_no_banco'
     * ];
     *
     * </code>
     *
     * @var array[string]string
     */
    protected $searchBy = [];

    /**
     * @var array filtros vindos da requisicao
     */
    protected $queryParams = [];

    /**
     * Model constructor.
     * @param Container $app
     * @param array|Array $configParams
     */
    public function __construct(Container $app, array $configParams)
    {
        if (is_null($this->table)) {
            throw new \InvalidArgumentException('Parametro \'table\' nao implementado.');
        }

        if (is_null($this->defaultSort)) {
            throw new \InvalidArgumentException('Parametro \'DefaultSort\' nao implementado.');
        }

        if (!isset($configParams['queryParams'])) {
            throw new \InvalidArgumentException('Parametro \'queryParams\' nao implementado.');
        }

        $readReplica = (empty($configParams['readReplica'])) ? false : $configParams['readReplica'];

        $this->app = $app;

        $this->pdo = new Connection($app, $readReplica);
        $this->filter = new PDOFilter;

        $this->queryParams = $this->app['sanitize']($configParams['queryParams']);
        $this->setOrder();
    }

    protected function execute($query)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->filter->getParam());
        $this->resetFilter();

        return $stmt->fetchAll();
    }

    public function setOrder()
    {
        $sort = empty($this->queryParams['sort']) ? $this->defaultSort : $this->queryParams['sort'];

        $arrayFields = [];
        if (!empty($sort)) {
            $arraySort = explode(',', $sort);

            foreach ($arraySort as $field) {
                $direction = 'ASC';
                if ($field{0} == '-') {
                    $direction = 'DESC';
                    $field = substr($field, 1);
                }
                if (!empty($this->searchBy[$field])) {
                    $arrayFields[$this->searchBy[$field]] = $direction;
                }
            }
        }
        $this->filter->setOrder($arrayFields);
        return $arrayFields;
    }

    public function count($table = null)
    {
        $table = (!$table) ? $this->table : $table;

        $query = "SELECT count(1) as count FROM  " . $table . $this->filter->getWhere();

        $result = $this->execute($query);

        $count = (count($result) > 1) ? count($result) : (int)$result[0]['count'];

        return $count;
    }

    public function resetFilter()
    {
        $this->filter = new PDOFilter;
        $this->setOrder();
    }

    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param null $idAmbiente
     * @return $this
     */
// TODO - Transformar porParceiro

    // public function porAmbiente($idAmbiente = null)
    // {
    //     if (is_null($idAmbiente)) {
    //         $idAmbiente = $this->app->user['environment_id'];
    //     }
    //     $this->filter->addFilter('AND amb_int_codigo = :amb_int_codigo', array(':amb_int_codigo' => $idAmbiente));
    //     return $this;
    // }
}
