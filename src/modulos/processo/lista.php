
    <?php
    use mc\processo\processo;
    use mc\motivo\motivo;
    $processo  = new processo();


    if ($_SESSION["mc_user_grupo"] == 1 || $_SESSION["mc_user_grupo"] == 4) {
        $db::$conn->execute($processo->selectAll());
        $total = $db::$conn->getNumRows();
    }else{
        $db::$conn->execute($processo->selectAllByUser( $_SESSION["mc_user_sq"]));
        $total = $db::$conn->getNumRows();
    }

    function getAllMotivo($db){         
        $motivo = new motivo(); 
        $tmp = '';
        $db::$conn->execute( $motivo->selectAll());           
        while($dados = $db::$conn->getObject()) { 
            $tmp.='<option value="'.$dados->motivo_id.'" >'.$dados->motivo.'</option>';
        }
        return $tmp;
        
    }
     
    ?>
    <button id="initDistribuicao" onclick="javascript:distribue();" title="" disabled="disabled" class="button redB" style="margin: 5px;position: relative;top: 48px;">Redistribuir Processos</button>
    <div class="widget" style="margin-top: 57px !important;">

        <div class="title">
            <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><? echo $db::$conn->getNumRows()." ".$modulo."s listados"; ?></h6>
        </div>

        <form  id="processForm">    
        <div id="reload">
            <table cellpadding="0" cellspacing="0" border="0" class="display dTable2">
                <thead>
                <tr>                   
                    <td><center><input type="checkbox" class="checkall" /></center></td>
                    <th>Protocolo</th>
                    <th>Andamento</th>
                    <th>Funcion&#225;rio</th>
                    <th>Origem</th>
                    <th>Data</th>
                    <th>Natureza Jur&#237;dica</th>
                    <th>Nome da Empresa</th>
                    <th>A&#231;&#227;o</th>
                </tr>
                </thead>
                <tbody id="tbody">
                <? while($dados = $db::$conn->getObject()) { ?>
                    <tr class="gradeA">                       
                       	<td><center><input type="checkbox" name="processos[]" value="<?=$dados->NR_PROTOCOLO?>" class="oneprocess" /></center></td>
                        <td class="textC"><?=$dados->NR_PROTOCOLO?></td>
                        <td class="textC"><?=$dados->SQ_ANDAMENTO?></td>
                        <td class="textC"><?=$dados->NO_LOGIN?></td>
                        <td class="textC"><?=$dados->SI_SECAO_ORIGEM?></td>
                        <td class="textC"><?=$dados->DT_ANDAMENTO . " " . $dados->HORA_ANDAMENTO ?></td>
                        <td><?=$dados->NO_NATUREZA?></td>
                        <td><?=($dados->NO_EMPRESARIAL)?></td>
                        <td class="center">
                            <a class="tipS" title="Trocar  <?=utf8_decode("funcionário")?>" href="<?=URL.'processo/form/'.base64_encode($dados->NR_PROTOCOLO."-".$dados->SQ_ANDAMENTO)?>"><img style="margin-right: 8px" src="<?=URL?>images/icons/edit.png" alt="" class="titleIcon" /></a>
                        </td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
        </form>
    </div>
<script type="text/javascript">
    var urlReload = "<?=URL?>reloadAjax.php";

    $('.checkall').live('click',function () {
        $(this).parents('table:eq(0)').find(':checkbox').attr('checked', this.checked); 
        
    });

     $('.oneprocess,.checkall').live('click',function () {
        setMark();
     });

     function setMark () {
        if( $('.oneprocess:checked').length ) {
            $('#initDistribuicao').removeAttr('disabled');
        
        } else {
            $('#initDistribuicao').removeAttr('disabled').attr('disabled','disabled').val('none');
        }   
     }

    function distribue () {      

        sweetConfirm('SISDAP','Deseja realmente resdistribuir os processos selecionados?',sweetMotivo,'<? echo getAllMotivo($db);?>');
    }



    function reloadPage() {

        $.get(urlReload, function(data) {
            //$('#reload').html(data);
            location.reload();
        });

    }
    setInterval(function(){
        reloadPage();
    },120000);  
</script>
