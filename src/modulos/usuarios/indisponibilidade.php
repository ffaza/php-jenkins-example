<?php
use mc\usuarios\usuarios;
use mc\usuarios\usuariosIndisponibilidade;
use mc\notify\sucess;
use mc\notify\failure;

if(!$idReg){
    new failure("Usuário invalido, aguarde...");
    echo '<meta http-equiv="refresh" content="1;url='.URL.'usuarios/lista" />';
    die();
}

    $usr = new usuarios("",$idReg);
    $db::$conn->execute($usr->selectId($idReg));
    $user = $db::$conn->getObject();
    $db::$conn->clear();

    $indi = new usuariosIndisponibilidade();
    $db::$conn->execute($indi->selectId($idReg));
?>
<div class="horControlB">
    <ul>
        <li><a href="<?=URL?>usuarios/indisponibilidadeForm/<?=$idReg?>" title=""><img src="<?=URL?>images/icons/control/16/plus.png" alt="" /><span>Novo Registro</span></a></li>
        <li><a href="#" title=""><img src="<?=URL?>images/icons/control/16/user.png" alt="" /><span><?=$user->NO_FUNCIONARIO?></span></a></li>
    </ul>
</div>

<div class="widget">
    <div class="title">
        <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><? echo ucfirst($modulo); ?></h6>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="display dTable">
        <thead>
        <tr>
            <th>Data Inicio</th>
            <th>Data Fim</th>
             <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <? while($registro = $db::$conn->getObject()) {
            $edit = $registro->ind_inicio."/".$registro->ind_fim;
            ?>
            <tr class="gradeA">
                <td><?=$registro->inicio?></td>
                <td><?=$registro->fim?></td>
                <td class="center">
                    <a href="<?=URL.'usuarios/indisponibilidadeForm/'.$idReg?>/delete/<?=$edit?>" onclick="return confirm_delete()"><img style="margin-right: 8px" src="<?=URL?>images/icons/remove.png" alt="" class="titleIcon" /></a>
                </td>
            </tr>
        <? } ?>
        </tbody>
    </table>
</div> <div id="botao" <?if(!$idReg){?>style="display: none"<?}?> class="formSubmit esconder">
    <a href="<?=URL.'usuarios/lista/'.$idReg?>"/> <input type="button" class="blueB" value="Voltar"></a>
</div>