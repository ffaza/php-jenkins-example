<?php
use mc\usuarios\usuarios;
use mc\notify\sucess;
use mc\notify\failure;

$strButton  = "Salvar";
$acao       = filter_input(INPUT_POST,"acao",FILTER_SANITIZE_STRING);

if($action=="inative" && $idReg) {

    $usr = new usuarios("",$idReg);
    if($db::$conn->execute($usr->inative()))
    {
        geraLog("Inativou usuario",$idReg,$db);
        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/lista" />';
        die();
    }else{new failure("Tente novamente.");}

}elseif($action=="active" && $idReg) {

    $usr = new usuarios("",$idReg);
    if($db::$conn->execute($usr->active()))
    {
        geraLog("Ativou usuario",$idReg,$db);
        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/lista" />';
        die();
    }else{new failure("Tente novamente.");}

} elseif(!$action && $idReg) {

    $usr = new usuarios("",$idReg);
    $db::$conn->execute($usr->selectId($idReg));
    $registro = $db::$conn->getObject();
    $db::$conn->clear();
    $acao = "update";

} elseif ($acao) {

    $codigo     = filter_input(INPUT_POST,"codigo");
    $usuario    = filter_input(INPUT_POST,"usuario");
    $nome       = filter_input(INPUT_POST,"nome");
    $grupo      = filter_input(INPUT_POST,"grupoUsuario");
    $matricula  = filter_input(INPUT_POST,"matricula");
    $natureza   = $_POST["natureza"];

    $usr = new usuarios($usuario,$codigo, $grupo, $matricula, $natureza, $nome,$acao);

    if($db::$conn->execute($usr->save()))
    {
        $db::$conn->execute($usr->clearNatureza());
        foreach($natureza as $value)
        {
            $db::$conn->execute($usr->insertNatureza($value))  ;
        }

        if($acao=="insert"){geraLog("Adicionou um usuario",$usuario,$db);}
        else {geraLog("Editou um usuario",$usuario,$db);}

        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/lista" />';
        die();
    }else{new failure("Tente novamente.");}
}
if(!$acao){$acao="insert";}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('input').keypress(function (e) {
            var code = null;
            code = (e.keyCode ? e.keyCode : e.which);
            return (code == 13) ? false : true;
        });
    });
</script>
<script type="text/javascript">
    var tempo;

    function dasabilitarenter() {

        var tecla = event.keyCode;
        if ((tecla == 13)) {
            return false;
        }
        return tecla;
    }

    function delay()
    {
        var us = document.getElementById("usuario");
        $("#usuario").val(us.value.toString().toUpperCase());
        window.clearTimeout(tempo);
        tempo = window.setTimeout("getUsr2()", 700);
    }

    function getUsr2()
    {
        $("#load").show();
        $("#details").hide();
        $("#botao").hide();
        $("#codigo").val("");
        $("#matricula").val("");
        $("#nome").val("");
        var us = document.getElementById("usuario");
        $.post( "../webservice/getUsuario.php", { usuario: ''+us.value.toString().toUpperCase()+''})
            .done(function( data ) {
                //alert('|'+data+'|');
                if(data.trim() == "usrduplicado"){
                    alert("<?=utf8_decode("Usuário")?> "+us.value+" <?=utf8_decode("já")?> cadastrado no sistema.");
                } else {
                    var $dados = data.split(";");
                    if($dados[0]!="Array") {
                        $("#usuario").val(us.value.toString().toUpperCase());
                        $("#codigo").val($dados[0]);
                        $("#matricula").val($dados[1]);
                        $("#nome").val($dados[2]);
                        $("#details").show();
                        $("#botao").show();
                    }
                }
                $("#load").hide();
            });
    }
</script>
<form method="post" id="usualValidate" class="form" action="<?=URL?>usuarios/form" onKeyPress="return dasabilitarenter();">
    <input type="hidden" value="<?=$idReg?>" name="idUpdate">
    <input type="hidden" value="<?=$acao?>" name="acao">

    <fieldset>
        <div class="widget">
            <div class="title">
                <img src="<?=URL?>images/icons/dark/list.png" alt="" class="titleIcon" />
                <div class="loader" style="display: none" id="load"><img src="<?=URL?>images/loaders/loader.gif" alt="" style="margin: 5px;"></div>
            </div>
            <div class="formRow">
                <label><?=utf8_decode("Usuário")?>:</label>
                <div class="formRight"><input value="<?=$registro->NO_LOGIN?>" id="usuario" name="usuario" class="required" autofocus="true " onkeyup="delay()" type="text" placeholder="Digite o nome do usuário para importar os dados" <?if($idReg){?>readonly<?}?>/></div>
                <div class="clear"></div>
            </div>
            <div <?if(!$idReg){?>style="display: none"<?}?> id="details">
                <div class="formRow">
                    <label>Código do <?=utf8_decode("usuário")?>:</label>
                    <div class="formRight"><input name="codigo" id="codigo"  type="text" value="<?=$registro->SQ_FUNCIONARIO?>" placeholder="automatico..." readonly/></div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label><?=utf8_decode("Matrícula")?>:</label>
                    <div class="formRight"><input id="matricula" name="matricula" type="text" value="<?=$registro->NR_MATRICULA?>" placeholder="automatico..." readonly/></div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label>Nome:</label>
                    <div class="formRight"><input id="nome" name="nome" type="text" value="<?=$registro->NO_FUNCIONARIO?>" placeholder="automatico..." readonly/></div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label>Grupo de <?=utf8_decode("Usuário")?>:</label>
                    <div class="formRight">
                        <?
                            use mc\usuarios\usuariosGrupo;
                            $gp = new usuariosGrupo();
                            $db::$conn->execute($gp->selectAll());
                        ?>
                        <select name="grupoUsuario" class="required _select">
                            <option value="">Selecione...</option>
                            <?
                            while($dados = $db::$conn->getObject()) {
                                echo '<option value="'.$dados->grp_id.'" '.selected($dados->grp_id,$registro->grp_id).'>'.$dados->grp_nome.'</option>';
                            }
                            function selected($v1,$v2){
                                if($v1==$v2) return "selected";
                            }

                            ?>
                        </select>
                    </div>
                    <div class="clear"></div>

                </div>
                <div class="formRow">
                    <label>Natureza <?=utf8_decode("Jurídica")?>:</label>
                    <?
                    use mc\naturezajuridica\naturezajuridicaWS;
                    use mc\naturezajuridica\natureza;

                    $ws     = new natureza($idReg);
                    $nat    = new natureza($idReg);

                    $db::$conn->execute($ws->selectAll());
                    $arr = $db::$conn->toArray();
                    foreach($arr  as $dds)
                    {
                        echo '<div class="formRight"><input class="_checkbox" type="checkbox" name="natureza[]" id="natureza[]" value="'.$dds->CO_NATUREZA.'" '.ckecked($dds->CO_NATUREZA,$db,$idReg,$nat).'/>'.utf8_encode($dds->NO_NATUREZA).'</div>';
                    }
                    function ckecked($v1,$db,$idReg,$nat){
                        if($idReg) {
                            $db::$conn->clear();
                            $db::$conn->execute($nat->selectAllByUser());
                            while ($dados = $db::$conn->getObject()) {
                                if ($v1 == $dados->CO_NATUREZA_JURIDICA) return "checked";
                            }
                        }else{return "checked";}
                    }
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </fieldset>
        <div id="botao" <?if(!$idReg){?>style="display: none"<?}?> class="formSubmit esconder">
            <input type="button" class="blueB" value="Voltar" onClick="history.go(-1)">
            <input type="submit" value="Salvar" class="redB" />
        </div>
</form>