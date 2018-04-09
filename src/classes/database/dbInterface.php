<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 07/10/2014
 * Time: 08:48
 */
namespace mc\database;
interface dbInterface
{
    function __construct($host,$user,$pass,$banc);
    public function execute($query);
    public function getObject();
    public function getArray();
    public function getNumRows();
    public function clear();
    public function executeOnly($query);
    public function getObjectByResult($rs);
    public function toArray();
}