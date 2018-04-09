<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 03/10/2014
 * Time: 14:25
 */
namespace mc\notify;
class failure extends notify {

    protected function getNotify()
    {
        return '<div class="nNote nFailure hideit"><p><strong>ERRO: </strong>'.$this->string.'</p></div>';
    }

}