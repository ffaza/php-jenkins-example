<?php
namespace mc\cron;
class cron {

    public function getLastData()
    {
        $result = "SELECT convert(VARCHAR(10),max(data_atualizacao),103) AS dia,convert(VARCHAR(10),max(data_atualizacao),108) AS hora FROM cron";
        return $result;
    }

} 