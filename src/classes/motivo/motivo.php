<?php

namespace mc\motivo;

class motivo {

	protected	$motivo_id;
	protected	$motivo;

    public function selectAll()
    {
        $sql = "select * from motivo";
        return $sql;

    } 
}