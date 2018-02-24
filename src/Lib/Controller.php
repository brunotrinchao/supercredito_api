<?php
namespace Lib;

use Slim\Container;

class Controller
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var StdClass
     */
    protected $user;

    /**
     * @var Lib\Pagination
     */
    protected $pagination;

    public function __construct(Container $container)
    {
        $this->app = $container;
        $this->user = $this->app->get('user');
        $this->pagination = new Pagination;
    }

    protected function setPagination($model, $count, $request)
    {
        $this->pagination->setCount($count);
        $limit = $this->pagination->getLimit($request);

        $model->getFilter()->setLimit($limit[0], $limit[1]);
        return $this->pagination->getLinks($request);
    }
}
