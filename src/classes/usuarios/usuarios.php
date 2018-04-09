<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 07/10/2014
 * Time: 16:56
 */

namespace mc\usuarios;


class usuarios {
    private $table = "funcionario";
    private $codigo;
    private $usuario;
    private $matricula;
    private $nome;
    private $grupo;
    private $natureza;
    private $atv;
    private $acao;

    function __construct($usuario=null,$codigo=null, $grupo=null, $matricula=null, $natureza=null, $nome=null,$acao=null)
    {
        $this->codigo   = $codigo;
        $this->grupo    = $grupo;
        $this->matricula = $matricula;
        $this->natureza = $natureza;
        $this->nome     = $nome;
        $this->usuario  = $usuario;
        $this->acao    = $acao;
    }
    
    public function save()
    {
        if($this->acao == "insert"){return $this->getInsert();} else {return $this->getUpdate();}
    }

    private function getUpdate()
    {
        return "UPDATE funcionario
                SET
                    grp_id = '".$this->grupo."',
                    NR_MATRICULA = '".$this->matricula."',
                    NO_FUNCIONARIO = '".$this->nome."',
                    NO_LOGIN = '".$this->usuario."'
                WHERE SQ_FUNCIONARIO = '".$this->codigo."'";
    }

    private function getInsert()
    {
        return "INSERT INTO funcionario (SQ_FUNCIONARIO, grp_id, NR_MATRICULA, NO_FUNCIONARIO,NO_LOGIN, fnc_ativo) VALUES ('{$this->codigo}', '{$this->grupo}', '{$this->matricula}', '{$this->nome}','".$this->usuario."', 1)";
    }

    public function inative()
    {
        $sql = "UPDATE funcionario
                SET
                    fnc_ativo = '0'
                WHERE SQ_FUNCIONARIO = '".$this->codigo."'";
        return $sql;
    }
    public function active()
    {
        $sql = "UPDATE funcionario
                SET
                    fnc_ativo = '1'
                WHERE SQ_FUNCIONARIO = '".$this->codigo."'";
        return $sql;
    }

    public function getUsuariosByNatureza($natureza)
    {
        $sql = "SELECT
                        f.SQ_FUNCIONARIO
                    FROM
                        funcionario f,
                        funcionario_natureza fn
                    WHERE
                        fn.CO_NATUREZA_JURIDICA = '{$natureza}'
                        AND fn.SQ_FUNCIONARIO = f.SQ_FUNCIONARIO
                        AND f.fnc_ativo = 1
                        AND f.SQ_FUNCIONARIO NOT IN (SELECT SQ_FUNCIONARIO FROM indisponibilidade WHERE  CAST(getdate() AS DATE) BETWEEN CAST(ind_inicio AS DATE) AND CAST(ind_fim AS DATE))
          ORDER BY f.SQ_FUNCIONARIO ";
        return $sql;
    }

    public function getUsuariosByNaturezaForm($natureza)
    {
        $sql = "SELECT
                    f.SQ_FUNCIONARIO,
                    f.NO_LOGIN
                FROM
                    funcionario f,
                    funcionario_natureza fn
                WHERE
                    fn.CO_NATUREZA_JURIDICA = '{$natureza}'
                    AND fn.SQ_FUNCIONARIO = f.SQ_FUNCIONARIO
                    AND f.fnc_ativo = 1
                ORDER BY f.SQ_FUNCIONARIO";
        return $sql;
    }


    public function selectAll($where=null,$order=null)
    {
        $sql = "SELECT * FROM ".$this->table;
        $sql .=" join grupo on grupo.grp_id = ".$this->table.".grp_id ";
        $where ? $sql .=" WHERE ".$where : null;
        $order ? $sql .=" ORDER BY ".$order : null;
        return $sql;
    }

    public function selectId($id)
    {
        $sql = "SELECT * FROM ".$this->table." where SQ_FUNCIONARIO=".$id;
        return $sql;
    }
    public function selectLogin()
    {
        $sql = "SELECT * FROM ".$this->table." where NO_LOGIN= '".$this->usuario."'";
        return $sql;
    }

    public function clearNatureza()
    {
        $sql = "delete FROM funcionario_natureza where SQ_FUNCIONARIO= '".$this->codigo."'";
        return $sql;
    }

    public function insertNatureza($natureza)
    {
        $sql = "INSERT INTO funcionario_natureza (SQ_FUNCIONARIO, CO_NATUREZA_JURIDICA) VALUES ('".$this->codigo."', '".$natureza."')";
        return $sql;
    }

    /**
     * @return null
     */
    public function getAcao()
    {
        return $this->acao;
    }

    /**
     * @param null $acao
     */
    public function setAcao($acao)
    {
        $this->acao = $acao;
    }

    /**
     * @return mixed
     */
    public function getAtv()
    {
        return $this->atv;
    }

    /**
     * @param mixed $atv
     */
    public function setAtv($atv)
    {
        $this->atv = $atv;
    }

    /**
     * @return null
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param null $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return null
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param null $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @return null
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param null $matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * @return null
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * @param null $natureza
     */
    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
    }

    /**
     * @return null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param null $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return null
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param null $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }



} 