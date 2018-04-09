<?php
session_destroy();
geraLog("Saiu do sistema","",$db);
echo '<meta http-equiv="refresh" content="0;url='.URL.'" />';
die();