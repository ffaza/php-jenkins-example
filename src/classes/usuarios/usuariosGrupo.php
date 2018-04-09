<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 06/10/2014
 * Time: 17:36
 */

namespace mc\usuarios;


class usuariosGrupo {
    private $table = "grupo";
    private $id;
    private $grupo;

    function __construct($grupo=null,$id=null)
    {
        $this->grupo = $grupo;
        $this->id = $id;
    }

    public function save()
    {
        if($this->id>0){$sql = "UPDATE {$this->table} SET grp_nome='{$this->grupo}' where grp_id='{$this->id}'";}
        else {$sql = "INSERT INTO ".$this->table." (grp_nome) VALUES ('".$this->grupo."')";}
        return $sql;
    }

    public function delete()
    {
        $sql = "DELETE FROM ".$this->table." where grp_id='{$this->id}'";
        return $sql;
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
        $sql = "SELECT * FROM ".$this->table." where grp_id=".$id;
        return $sql;
    }

} 