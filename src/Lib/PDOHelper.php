<?php

namespace Lib;
// use Exception;

class PDOHelpers{
    /*
     @param PDO       PDO instance
     @param String    query to procedure
     @param Array     procedure parameters

     @return Array
    */
    public static function procedure($pdo, $query, $param) {
        $stmt = $pdo->prepare($query);
        $stmt->execute($param);
        $return = [];
        preg_match_all('/(@)\w+/', $query, $out);

        if(!empty($out[0])) {
            $retsql = "SELECT ".implode(',', $out[0]);
            $stmt = $pdo->prepare($retsql);
            $stmt->execute();
            $return = $stmt->fetchAll();
        }

        return $return;
    }
}
