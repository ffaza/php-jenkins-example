<?php
use mc\usuarios\usuariosGrupo;
use mc\notify\sucess;
use mc\notify\failure;

$usuario    = filter_input(INPUT_POST,"grupoUsuario", FILTER_SANITIZE_STRING);
$idUpdate   = filter_input(INPUT_POST,"idUpdate", FILTER_VALIDATE_INT);

if($action=="delete" && $idReg) {
    $grupo = new usuariosGrupo("",$idReg);
    if($db::$conn->execute($grupo->delete()))
    {
        geraLog("Deletou um grupo de usario",$idReg,$db);
        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/grupo" />';
        die();
    }else{new failure("Tente novamente.");}

} elseif ($usuario) {
    $grupo = new usuariosGrupo($usuario,$idUpdate);
    if($db::$conn->execute($grupo->save()))
    {
        if(!$idUpdate){geraLog("Adicionou um grupo de usuario",$usuario,$db);}
        else {geraLog("Editou um grupo de usuario",$usuario,$db);}

        new sucess("Por favor, aguarde...");
        echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/grupo" />';
        die();
    }else{new failure("Tente novamente.");}

} elseif ($idReg) {
    $grupo = new usuariosGrupo();
    $db::$conn->execute($grupo->selectId($idReg));
    $dados = $db::$conn->getObject();
}
?>
<form action="<?=URL?>usuarios/grupoForm" class="form" method="post">
    <input type="hidden" value="<?=$idReg?>" name="idUpdate">
    <fieldset>
        <div class="widget">
            <div class="title"><img src="<?=URL?>images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Grupo de Usuário</h6></div>
            <div class="formRow">
                <label>Grupo de Usuário:</label>
                <div class="formRight">
                    <input type="text" autofocus="true" name="grupoUsuario" id="grupoUsuario" value="<?=$dados->grp_nome?>" placeholder="Digite o nome do Grupo de Usuário" />
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </fieldset><div class="formSubmit esconder"><input type="submit" value="Salvar" class="redB" /></div>
</form>