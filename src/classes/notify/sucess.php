<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 03/10/2014
 * Time: 14:25
 */
namespace mc\notify;
class sucess extends notify{

    protected function getNotify()
    {
        return '<div class="nNote nSuccess hideit"><p><strong>SUCESSO: </strong>'.$this->string.'</p></div>';
    }

}