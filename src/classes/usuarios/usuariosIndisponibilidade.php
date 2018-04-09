<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 15/10/2014
 * Time: 09:00
 */

namespace mc\usuarios;


class usuariosIndisponibilidade {

    private $table = "indisponibilidade";
    private $sq_funcionario;
    private $inicio;
    private $fim;

    function __construct($sq_funcionario=null, $inicio=null,$fim=null )
    {
        $this->fim = $fim;
        $this->inicio = $inicio;
        $this->sq_funcionario = $sq_funcionario;
    }

    public function selectAll($where=null,$order=null)
    {
        $sql = "SELECT * FROM ".$this->table;
        $where ? $sql .=" WHERE ".$where : null;
        $order ? $sql .=" ORDER BY ".$order : null;
        return $sql;
    }

    public function selectId($id)
    {
        $sql = "SELECT *, convert(varchar, ind_inicio, 103) as inicio,convert(varchar, ind_fim, 103) as fim  FROM ".$this->table." where SQ_FUNCIONARIO=".$id;
        return $sql;
    }

    public function selectDateRange($ini,$fim)
    {
        $sql = "SELECT *, convert(varchar, ind_inicio, 103) as inicio,convert(varchar, ind_fim, 103) as fim  FROM ".$this->table." where ind_inicio='".$ini."' and ind_fim='".$fim."'";
        return $sql;
    }

    public function delete($id,$ini,$fim)
    {
        $sql = "DELETE FROM ".$this->table." where ind_inicio='".$ini."' and ind_fim='".$fim."' and SQ_FUNCIONARIO=".$id;
        return $sql;
    }

    public function save()
    {
        return $this->getInsert();
    }

    private function getInsert()
    {
        return "INSERT INTO indisponibilidade (SQ_FUNCIONARIO, ind_inicio, ind_fim)
                VALUES ('" . $this->sq_funcionario . "','" . $this->inicio . "','" . $this->fim . "')";
    }


} 