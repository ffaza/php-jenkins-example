<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 03/10/2014
 * Time: 14:24
 */
namespace mc\notify;
abstract class notify {

    protected $string;

    function __construct($string)
    {
        $this->string = $string;
        echo$this->getNotify();
    }

}