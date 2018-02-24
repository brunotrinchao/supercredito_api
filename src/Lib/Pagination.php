<?

namespace Lib;

use \Psr\Http\Message\ServerRequestInterface as Request;

class Pagination
{
    protected $page = 1;
    protected $perPage = 20;
    protected $maxPerPage = 10000;
    protected $totalPages = 1;
    protected $count = 0;

    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getLimit(Request $request)
    {
        $params =  $request->getQueryParams();

        $this->page = empty($params['page']) ? 1 : $params['page'];
        $this->perPage = (int) (empty($params['per_page']) ? $this->perPage : ($params['per_page'] > $this->maxPerPage ? $this->maxPerPage : $params['per_page']));
        $this->totalPages = ceil($this->count / $this->perPage);

        $start = (($this->page - 1) * $this->perPage);
        return [$start, $this->perPage];
    }

    public function getLinks(Request $request)
    {
        $params =  $request->getQueryParams();
        $uri = $request->getUri();
        $path = $uri->getPath();
        $basePath = $uri->getBasePath();
        // $base = $basePath . '/' . $path;
        $base = $path;

        $urlSelf = $base . ((empty($params)) ? '' : '?' . http_build_query($params));
        $urlFirst = $this->getUrlFirst($base, $params);
        $urlPrev = $this->getUrlPrev($base, $params);
        $urlNext = $this->getUrlNext($base, $params);
        $urlLast = $this->getUrlLast($base, $params);

        $links['first'] = $urlFirst;
        $links['prev'] = $urlPrev;
        $links['self'] = $urlSelf;
        $links['next'] = $urlNext;
        $links['last'] = $urlLast;
        $links['page'] = $this->page;
        $links['per_page'] = $this->perPage;
        $links['total_pages'] = $this->totalPages;
        $links['count'] = $this->count;

        return $links;
    }

    /**
     * @deprecated utilizar getOrder do Filter
     *
     * @param $sort
     * @param $dictionary
     * @return array
     */
    public function getOrder($sort, $dictionary)
    {
        $order = '';
        $arrayFields = [];
        if (!empty($sort)) {
            $arraySort = explode(',', $sort);
            foreach ($arraySort as $field) {
                $direction = 'ASC';
                if ($field{0} == '-') {
                    $direction = 'DESC';
                    $field = substr($field, 1);
                }
                if (!empty($dictionary[$field])) {
                    $arrayFields[$dictionary[$field]] = $direction;
                }
            }
        }
        return $arrayFields;
    }

    private function getUrlFirst($base, $params)
    {
        $first = false;
        if ($this->page > 1) {
            $params['page'] = 1;
            $first = $base . '?' . http_build_query($params);
        }
        return $first;
    }

    private function getUrlLast($base, $params)
    {
        $last = false;
        if ($this->page < $this->totalPages) {
            $params['page'] = $this->totalPages;
            $last = $base . '?' . http_build_query($params);
        }
        return $last;
    }

    private function getUrlNext($base, $params)
    {
        $next = false;
        if ($this->page < $this->totalPages) {
            $params['page'] = $this->page + 1;
            $next = $base . '?' . http_build_query($params);
        }

        return $next;
    }

    private function getUrlPrev($base, $params)
    {
        $prev = false;
        if ($this->page > 1) {
            $params['page'] = $this->page - 1;
            $prev = $base . '?' . http_build_query($params);
        }

        return $prev;
    }
}