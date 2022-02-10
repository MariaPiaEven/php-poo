<?php

class PDOperso extends PDO {

    function __construct(
        $host = 'localhost',
        $dbname = 'php_poo', 
        $user = 'root', 
        $pwd = '',
        $port = 3306){

        parent::__construct(
            'mysql:host='. $host .':'. $port .';dbname='. $dbname .';charset=UTF8',
            $user,
            $pwd

        );
    }
}
?>