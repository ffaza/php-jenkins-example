<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 03/10/2014
 * Time: 14:25
 */
namespace mc\notify;
class information extends notify{

    protected function getNotify()
    {
        return '<div class="nNote nInformation hideit"><p><strong>INFORMA&Ccedil;&Atilde;O: </strong>'.$this->string.'</p></div>';
    }

}