<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 06/10/2014
 * Time: 13:37
 */

namespace mc\pre;


class pre {

    function __construct($str)
    {
        echo "<pre>";
        print_r($str);
        echo "</pre>";
    }
}