<?php
use mc\processo\processo;
use mc\naturezajuridica\naturezajuridicaWS;
use mc\notify\sucess;
use mc\notify\failure;

$acao       = filter_input(INPUT_POST,"acao",FILTER_SANITIZE_STRING);

if(!$acao && $idReg) {
    $info = base64_decode($idReg);
    $info = explode("-",$info);
    $protocolo = $info[0];
    $andamento = $info[1];

    $processo = new processo();

    $db::$conn->execute($processo->selectByProtocoloAndAndamento($protocolo,$andamento));
    $registro = $db::$conn->getObject();
    $acao = "update";

} elseif ($acao) {

    $sq_funcionario  = filter_input(INPUT_POST,"sq_funcionario");
    $nr_protocolo    = filter_input(INPUT_POST,"nr_protocolo");
    $sq_andamento    = filter_input(INPUT_POST,"sq_andamento");

    $processo = new processo();
    $processo->setUpdate($nr_protocolo,$sq_andamento,$sq_funcionario);

    if($db::$conn->execute($processo->update()))
    {
        geraLog("Editou um protocolo",$usuario,$db);}
        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'processo/lista" />';
        die();

    }else{new failure("Tente novamente.");}
?>

<form method="post" id="usualValidate" class="form" action="<?=URL?>processo/form" >
    <input type="hidden" value="<?=$idReg?>" name="idUpdate">
    <input type="hidden" value="<?=$acao?>" name="acao">

    <fieldset>
        <div class="widget">
            <div class="title">
                <img src="<?=URL?>images/icons/dark/list.png" alt="" class="titleIcon" />
                <div class="loader" style="display: none" id="load"><img src="<?=URL?>images/loaders/loader.gif" alt="" style="margin: 5px;"></div>
            </div>
            <div class="formRow">
                <label>Protocolo:</label>
                <div class="formRight"><input value="<?=$registro->NR_PROTOCOLO?>" id="nr_protocolo" name="nr_protocolo" class="required" autofocus="true " onkeyup="delay()" type="text" placeholder="Digite o nome do usuário para importar os dados" <?if($idReg){?>readonly<?}?>/></div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                <label>Andamento:</label>
                <div class="formRight"><input id="sq_andamento" name="sq_andamento" type="text" value="<?=$registro->SQ_ANDAMENTO?>" placeholder="automatico..." readonly/></div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                <label>Origem:</label>
                <div class="formRight"><input id="origem" name="origem" type="text" value="<?=$registro->SI_SECAO_ORIGEM?>" placeholder="automatico..." readonly/></div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                    <label>Data:</label>
                    <div class="formRight"><input id="data" name="data" type="text" value="<?=$registro->DT_ANDAMENTO . " " . $registro->HORA_ANDAMENTO?>" placeholder="automatico..." readonly/></div>
                    <div class="clear"></div>
            </div>
            <div class="formRow">
                    <label>Natureza <?=utf8_decode("Jurídica")?>:</label>
                    <div class="formRight"><input id="natureza" name="natureza" type="text" value="<?=$registro->NO_NATUREZA?>" placeholder="automatico..." readonly/></div>
                    <div class="clear"></div>
            </div>
             <div class="formRow">
                    <label>Empresa</label>
                    <div class="formRight"><input id="empresa" name="empresa" type="text" value="<?=($registro->NO_EMPRESARIAL)?>" placeholder="automatico..." readonly/></div>
                    <div class="clear"></div>
            </div>
                    <div class="formRow">
                    <label><?=utf8_decode("Funcionário")?></label>
                    <div class="formRight">
                        <?
                        use mc\usuarios\usuarios;
                        $usr = new usuarios();
                        $db::$conn->execute($usr->getUsuariosByNaturezaForm($registro->CO_NATUREZA));
                        ?>
                        <select name="sq_funcionario" class="required _select" <? if($_SESSION["mc_user_grupo"] > 1 && $_SESSION["mc_user_grupo"] < 4){echo "disabled";} ?> >
                            <option value="">Selecione...</option>
                            <?
                            while($dados = $db::$conn->getObject()) {
                                echo '<option value="'.$dados->SQ_FUNCIONARIO.'" '.selected($dados->SQ_FUNCIONARIO,$registro->SQ_FUNCIONARIO).'>'.$dados->NO_LOGIN.'</option>';
                            }
                            function selected($v1,$v2){
                                if($v1==$v2) return "selected";
                            }

                            ?>
                        </select>
                    </div>
                    <div class="clear"></div>

                </div>
                <div class="clear"></div>

        </div>
    </fieldset>
    <div id="botao" <?if(!$idReg){?>style="display: none"<?}?> class="formSubmit esconder">
        <input type="button" class="blueB" value="Voltar" onClick="history.go(-1)">
        <?php if ($_SESSION["mc_user_grupo"] == 1) {?>
        <input type="submit" value="Salvar" class="redB" />
        <? }?>
    </div>
</form>