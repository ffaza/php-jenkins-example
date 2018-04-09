<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 03/10/2014
 * Time: 14:25
 */
namespace mc\notify;
class warning extends notify{

    protected function getNotify()
    {
        return '<div class="nNote nWarning hideit"><p><strong>ATEN&Ccedil;&Atilde;O: </strong>'.$this->string.'</p></div>';
    }
}