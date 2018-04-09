<?
use mc\usuarios\usuarios;
use mc\usuarios\usuariosGrupo;
$gp     = new usuariosGrupo();
$usr    = new usuarios();
$db::$conn->execute($usr->selectAll());
?>

<div class="controlB">
        <ul>
            <li><a href="<?=URL?>usuarios/form" title=""><img src="<?=URL?>images/icons/add-user.png" alt="" /><span>Novo usu&#225;rio</span></a></li>
        </ul>
        <div class="clear"></div>
</div>

<div class="widget">
    <div class="title">
        <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><? echo ucfirst($modulo); ?></h6>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="display dTable">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Matricula</th>
                <th>Login</th>
                <th>Nome</th>
                <th>A&#231;&#227;o</th>
            </tr>
        </thead>
    <tbody>
    <? while($dados = $db::$conn->getObject()) { ?>
        <tr class="gradeA">
            <td><?=$dados->grp_nome?></td>
            <td><?=$dados->NR_MATRICULA?></td>
            <td><?=$dados->NO_LOGIN?></td>
            <td><?=$dados->NO_FUNCIONARIO?></td>
            <td class="center">
                <a class="tipS" title="Editar usu&#225;rio" href="<?=URL.'usuarios/form/'.$dados->SQ_FUNCIONARIO?>"><img style="margin-right: 8px" src="<?=URL?>images/icons/edit.png" alt="" class="titleIcon" /></a>
                <a class="tipS" title="Indisponibilidade de usu&#225;rio" href="<?=URL.'usuarios/indisponibilidade/'.$dados->SQ_FUNCIONARIO?>"><img style="margin-right: 8px" src="<?=URL?>images/icons/control/16/date.png" alt="" class="titleIcon" /></a>
                <?
                 if($dados->fnc_ativo==1){
                ?>
                <a class="tipS" title="Inativar usu&#225;rio" href="<?=URL.'usuarios/form/'.$dados->SQ_FUNCIONARIO?>/inative">
                    <img style="margin-right: 8px" src="<?=URL?>images/icons/control/16/user.png" alt="Inativar usu&#225;rio" class="titleIcon" />
                </a>
                <? } else { ?>
                <a class="tipS" title="Ativar usu&#225;rio" href="<?=URL.'usuarios/form/'.$dados->SQ_FUNCIONARIO?>/active" >
                    <img style="margin-right: 8px" src="<?=URL?>images/icons/dark/user.png" alt="Ativar usu&#225;rio" class="titleIcon" />
                </a>
                <? } ?>
            </td>
        </tr>
    <? } ?>
    </tbody>
    </table>
</div>