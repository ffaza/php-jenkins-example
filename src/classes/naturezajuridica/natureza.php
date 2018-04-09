<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 09/10/2014
 * Time: 10:39
 */

namespace mc\naturezajuridica;


class natureza {

    private $codigo;
    private $usuario;

    function __construct($usuario=null)
    {
        $this->usuario = $usuario;
    }

    public function selectAllByUser()
    {
        return "select * from funcionario_natureza WHERE SQ_FUNCIONARIO=".$this->usuario;
    }

    public function selectAll()
    {
        return "select * from naturezajuridica ";
    }



} 