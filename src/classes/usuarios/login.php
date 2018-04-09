<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 09/10/2014
 * Time: 09:51
 */

namespace mc\usuarios;


class login {

    private $id;
    private $login;
    private $senha;
    private $grupo;
    private $nome;

    function __construct($login, $senha)
    {
        $this->login = $login;
        $this->senha = $senha;
    }

    public function userExists()
    {
        return "SELECT * FROM funcionario WHERE NO_LOGIN='".$this->login."' and fnc_ativo=1";
    }

    public function getLogin($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "usuario={$this->login}&senha={$this->senha}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, '');
        $server_output = curl_exec($ch);
        curl_close($ch);

        $dec = base64_decode($server_output);
        $dec = unserialize($dec);
        return $dec;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }




} 