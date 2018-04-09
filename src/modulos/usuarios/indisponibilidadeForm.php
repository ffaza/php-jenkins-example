<?php
use mc\usuarios\usuariosIndisponibilidade;
use mc\notify\sucess;
use mc\notify\failure;

$strButton  = "Salvar";
$acao       = filter_input(INPUT_POST,"acao",FILTER_SANITIZE_STRING);

if(!$idReg && !$dataini && !$datafim){
    new failure("Usuário invalido, aguarde...");
    echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/indisponibilidade/'.$idReg.'" />';
    die();
}

if($action=="delete" && $idReg && $dataini && $datafim) {
    $indi = new usuariosIndisponibilidade();

    if($db::$conn->execute($indi->delete($idReg,$dataini,$datafim)))
    {
        $ddslog = "Funcionario ".$idReg." Inicio:".$dataini." Fim:".$datafim;
        geraLog("Deletou indisponibilidade de usuario",$ddslog,$db);
        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/indisponibilidade/'.$idReg.'" />';
        die();
    }else{new failure("Tente novamente.");}

} elseif ($acao && $idReg) {

    $ini    = filter_input(INPUT_POST,"inicio");
    $fim    = filter_input(INPUT_POST,"fim");

    $tmp = explode("/","$ini");
    $ini = $tmp[2]."-".$tmp[1]."-".$tmp[0];
    $tmp = explode("/","$fim");
    $fim = $tmp[2]."-".$tmp[1]."-".$tmp[0];
    $indi = new usuariosIndisponibilidade($idReg,$ini,$fim);

    if($db::$conn->execute($indi->save()))
    {
        $ddslog = "Funcionario ".$idReg." Inicio:".$ini." Fim:".$fim;
        geraLog("Adicionou indisponibilidade de usuario",$ddslog,$db);
        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/indisponibilidade/'.$idReg.'" />';
        die();
    }else{new failure("Tente novamente.");}
}
if(!$acao){$acao="insert";}
?>
<form id="usualValidate" method="post" class="form" action="<?=URL?>usuarios/indisponibilidadeForm/<?=$idReg?>">
    <input type="hidden" value="<?=$idReg?>" name="idUpdate">
    <input type="hidden" value="<?=$acao?>" name="acao">
    <fieldset>
        <div class="widget">
            <div class="title">
                <img src="<?=URL?>images/icons/dark/list.png" alt="" class="titleIcon" />
                <div class="loader" style="display: none" id="load"><img src="<?=URL?>images/loaders/loader.gif" alt="" style="margin: 5px;"></div>
            </div>
            <div class="formRow">
                <label>Inicio:</label>
                <div class="formRight"><input class="maskDate required" value="<?=$registro->inicio?>" id="inicio" name="inicio"  type="text" /></div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                <label>Fim:</label>
                <div class="formRight"><input class="maskDate required" value="<?=$registro->fim?>" id="fim" name="fim" class="required" type="text" /></div>
                <div class="clear"></div>
            </div>
        </div>
    </fieldset>
    <div id="botao" <?if(!$idReg){?>style="display: none"<?}?> class="formSubmit esconder">
        <a href="<?=URL.'usuarios/indisponibilidade/'.$idReg?>"/> <input type="button" class="blueB" value="Voltar"></a>
        <input type="submit" value="<?=$strButton?>" class="redB" />
    </div>
</form>