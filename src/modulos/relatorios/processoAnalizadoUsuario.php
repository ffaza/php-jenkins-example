<?
use mc\usuarios\usuarios;
use mc\processo\processo;
use mc\naturezajuridica\naturezajuridicaWS;

$sq_funcionario = filter_input(INPUT_POST,'sq_funcionario',FILTER_VALIDATE_INT);
$rel_inicio     = filter_input(INPUT_POST,'inicio');
$rel_fim        = filter_input(INPUT_POST,'fim');

$interval = $rel_inicio. " - ".$rel_fim;
$tmp        = explode("/",$rel_inicio);
$rel_inicio = $tmp[2]."-".$tmp[1]."-".$tmp[0];
$tmp        = explode("/",$rel_fim);
$rel_fim    = $tmp[2]."-".$tmp[1]."-".$tmp[0];



?>
<div class="widget">
    <div class="title">
        <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6>Selecione um Funcion&#225;rio</h6>
    </div>
    <form method="post" id="usualValidate" class="form" action="<?=URL.$modulo.DIRECTORY_SEPARATOR.$page?>" >
        <div class="formRow">
            <label>Funcion&#225;rio:</label>
            <div class="formRight">
                <?
                $usr = new usuarios();
                $db::$conn->execute($usr->selectAll());
                ?>
                <select name="sq_funcionario" class="required _select">
                    <option value="" >Selecione...</option>
                    <?
                    while($dados = $db::$conn->getObject()) {
                        echo '<option value="'.$dados->SQ_FUNCIONARIO.'" '.selected($dados->SQ_FUNCIONARIO,$sq_funcionario).'>'.$dados->NO_LOGIN.'</option>';
                    }
                    function selected($v1,$v2){
                        if($v1==$v2) return "selected";
                    }

                    ?>
                </select>
            </div><div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Data Inicial:</label>
            <div class="formRight">
                <span class=""> <input class="datepicker required" value="<?=filter_input(INPUT_POST,'inicio')?>" id="inicio" name="inicio"  type="text" /></span>
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Data Final:</label>
            <div class="formRight">
                <span class=""> <input class="datepicker required" value="<?=filter_input(INPUT_POST,'fim') ? filter_input(INPUT_POST,'fim') : date('d/m/Y')?>" id="fim" name="fim"  type="text" /></span>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<a href="#" onclick="$('#usualValidate').submit()" title="" class="button blueB mt10"><span>Gerar Relatorio</span></a>
<?php

if($sq_funcionario)
{
    $usr = new usuarios();
    $db::$conn->execute($usr->selectId($sq_funcionario));
    $func = $db::$conn->getObject();

    $processo = new processo();
    $db::$conn->execute($processo->selectAnalyzedByUsuario($sq_funcionario,$rel_inicio,$rel_fim));
    $processList = $db::$conn->toArray();

    $rel_funcionario_login  = $func->NO_LOGIN;
    $rel_funcionario_nome   = $func->NO_FUNCIONARIO;
    $rel_quantidade         = count($processList);
    $rel_cols = array('Andamento','Funcion&#225;rio','Origem','Data Processo','Data Destino','Natureza Juridica','Nome da Empresa');

    $processSerialize   = base64_encode(serialize($processList));
    $colsSerialize      = base64_encode(serialize($rel_cols));
}
?>
<div id="relatorio" style="display: none">
    <div class="mt30" >
        <div style="float: left" >
            <form id="relPdf" target="_blank" method="post" name="relPdf" action="<?=URL?>tcpdf/pdf/processoAnalizadoUsuario.php">
                <input type="hidden" name="funcLogin" value="<?=$rel_funcionario_login?>">
                <input type="hidden" name="funcNome" value="<?=$rel_funcionario_nome?>">
                <input type="hidden" name="prossTotal" value="<?=$rel_quantidade?>">
                <input type="hidden" name="prossList" value="<?=$processSerialize?>">
                <input type="hidden" name="prossCols" value="<?=$colsSerialize?>">
                <input type="hidden" name="prossInterval" value="<?=$interval?>">
                <a href="#" onclick="$('#relPdf').submit()" title="" class="button redB" style="margin: 5px;"><img src="<?=URL?>images/icons/light/pdfDoc.png" alt="" class="icon" /><span>PDF</span></a>
            </form>
        </div>
        <div >
            <form id="relExcel" target="_blank" method="post" name="relPdf" action="<?=URL?>phpexcel/processoAnalizadoUsuario.php">
                <input type="hidden" name="funcLogin" value="<?=$rel_funcionario_login?>">
                <input type="hidden" name="funcNome" value="<?=$rel_funcionario_nome?>">
                <input type="hidden" name="prossTotal" value="<?=$rel_quantidade?>">
                <input type="hidden" name="prossList" value="<?=$processSerialize?>">
                <input type="hidden" name="prossCols" value="<?=$colsSerialize?>">
                <input type="hidden" name="prossInterval" value="<?=$interval?>">
                <a href="#" onclick="$('#relExcel').submit()" title="" class="button greenB" style="margin: 5px;"><img src="<?=URL?>images/icons/light/excelDoc.png" alt="" class="icon" /><span>EXCEL</span></a>
            </form>
        </div>
    </div>
    <div class="widget mt0" id="relatorioGrid" >
        <div class="title">
            <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" />
            <h6><?=$rel_quantidade?> processos analisados pelo usu&#225;rio [<?=trim($func->NO_LOGIN);?>] - <?=$func->NO_FUNCIONARIO;?></h6>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="display dTable">
            <thead>
            <tr>
                <th>Protocolo</th>
                <th>Andamento</th>
                <th>Origem</th>
                <th>Data Processo</th>
                <th>Data Destino</th>
                <th>Natureza Jur&#237;dica</th>
                <th>Nome da Empresa</th>
            </tr>
            </thead>
            <tbody>
            <? foreach($processList as $dados) {?>
                <tr class="gradeA">
                    <td class="textC"><?=$dados->NR_PROTOCOLO?></td>
                    <td class="textC"><?=$dados->SQ_ANDAMENTO?></td>
                    <td class="textC"><?=$dados->SI_SECAO_ORIGEM?></td>
                    <td class="textC"><?=$dados->DT_ANDAMENTO . " " . $dados->HORA_ANDAMENTO ?></td>
                    <td class="textC"><?=$dados->DT_DESTINO2 . " " . $dados->HR_DESTINO2?></td>
                    <td><?=$dados->NO_NATUREZA?></td>
                    <td><?=$dados->NO_EMPRESARIAL?></td>
                </tr>
            <? } ?>
            </tbody>
        </table>

    </div>
    <div class="mt0">
        <a href="#" onclick="$('#relPdf').submit()" title="" class="button redB" style="margin: 5px;"><img src="<?=URL?>images/icons/light/pdfDoc.png" alt="" class="icon" /><span>PDF</span></a>
        <a href="#" onclick="$('#relExcel').submit()" title="" class="button greenB" style="margin: 5px;"><img src="<?=URL?>images/icons/light/excelDoc.png" alt="" class="icon" /><span>EXCEL</span></a>
    </div>
</div>
<?
if($sq_funcionario){
    echo "<script>$('#relatorio').show('show');</script>";
}
?>