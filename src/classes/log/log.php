<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 09/10/2014
 * Time: 10:53
 */

namespace mc\log;


class log {
    private $funcionario;
    private $datahora;
    private $acao;
    private $dados;
    private $ip;

    function __construct($acao, $dados)
    {
        $this->acao         = $acao;
        $this->dados        = $dados;
        $this->funcionario  = $_SESSION["mc_user_sq"];
        $this->ip           = $_SERVER["REMOTE_ADDR"];
        $this->datahora     = date("Y-m-d H:i:s");
    }

    public function setLog()
    {
        return "INSERT INTO log (SQ_FUNCIONARIO, log_datahora, log_acao, log_dados, log_ip) VALUES ('".$this->funcionario."', '".$this->datahora."', '".$this->acao."', '".$this->dados."', '".$this->ip."')";
    }


} 