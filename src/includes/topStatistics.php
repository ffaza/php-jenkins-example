<?php

use mc\processo\processo;
$processo = new processo();
$processos_chart = $db::$conn->execute($processo->selectAll());
$total = $db::$conn->getNumRows();

use mc\cron\cron;
$cron = new cron();
$db::$conn->execute($cron->getLastData());
$last = $db::$conn->getObject();

?>
<div class="statsRow">
    <div class="wrapper statsItems">

        <!-- Stats item -->
        <div class="sItem ticketsStats">
            <h2><a title="" class="value"><?=$total?><span>Processos</span></a></h2>

        </div>
        <div class="sItem ticketsStats">
            <h2><a title="" class="value"><?=$last->dia." - ".$last->hora?><span>&#218;ltima Atualiza&#231;&#227;o</span></a></h2>

        </div>
    </div>
</div>

<div class="line"></div>