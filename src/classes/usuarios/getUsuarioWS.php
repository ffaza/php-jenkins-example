<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 06/10/2014
 * Time: 13:23
 */

namespace mc\usuarios;



class getUsuarioWS {

    protected $result;

    function __construct($result)
    {
        $this->$result = base64_decode($result);
    }
    /**
     * @return mixed
     */
    public function getResult()
    {
        return unserialize($this->result);
    }



} 