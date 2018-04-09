<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 06/10/2014
 * Time: 13:23
 */

namespace mc\naturezajuridica;

class naturezajuridicaWS {

    protected $url;
    protected $result;

    function __construct($url)
    {
        $this->url = $url;
    }

    public function getData()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_PROXY => '',
            CURLOPT_URL => "{$this->url}"
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return unserialize(base64_decode($resp));
    }
} 