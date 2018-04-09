<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 23/10/2014
 * Time: 13:17
 */

namespace mc\service;


class service {

    protected $url;
    protected $retorno;

    function __construct($url)
    {
        $this->url = $url;
        $this->getService();
    }


    public function getService()
    {
        $curl = curl_init();
		//curl_setopt($ch, CURLOPT_PROXY, '');
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_PROXY => '',
            CURLOPT_URL => "{$this->url}"
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
       $this->retorno = unserialize(base64_decode($resp));
    }

    public function getRetorno()
    {
        return $this->retorno;
    }



} 