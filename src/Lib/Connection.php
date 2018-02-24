<?php

namespace Lib;

use \PDO as PDO;

class Connection extends PDO
{
    public function __construct($c, $readReplica = false)
    {
        try {
            $timezone = (empty($c->request->getHeader('Timezone'))) ? $c['settings']['timezone'] : $c->request->getHeader('Timezone')[0];

            $db = $c['settings']['db'];
            $host = ($readReplica) ? $db['MYSQL_HOST_READ'] : $db['MYSQL_HOST'];

            parent::__construct("mysql:host=" . $host . ";dbname=" . $db['MYSQL_BASE'] . ';charset=' . $db['MYSQL_CHARSET'], $db['MYSQL_USER'], $db['MYSQL_PASS'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '" . $timezone . "'"]);

            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
