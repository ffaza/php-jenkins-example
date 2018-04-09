<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 07/10/2014
 * Time: 08:46
 */

namespace mc\database;


class database {

    static $conn = null ;    

    function __construct(dbInterface $connection)
    {
        $this::$conn = $connection;
    }
}