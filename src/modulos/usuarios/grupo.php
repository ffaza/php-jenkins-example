<?
use mc\usuarios\usuariosGrupo;
$gp = new usuariosGrupo();
$db::$conn->execute($gp->selectAll());
?>

        <div class="wrapper">
            <div class="controlB">
                <ul>
                    <li><a href="<?=URL?>usuarios/grupoForm" title=""><img src="<?=URL?>images/icons/add-user.png" alt="" /><span>Novo Grupo de usuário</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>

<div class="widget">
    <div class="title">
        <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6>Grupo de Usuario</h6>
    </div>
   <table cellpadding="0" cellspacing="0" border="0" class="display dTable">
    <thead>
    <tr>
        <th>Grupo</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    <? while($dados = $db::$conn->getObject()) { ?>
    <tr class="gradeA">
        <td><?=$dados->grp_nome?></td>
        <td class="center">
            <a class="tipS" title="Adicionar grupo" href="<?=URL.'usuarios/grupoForm/'.$dados->grp_id?>"><img style="margin-right: 8px" src="<?=URL?>images/icons/edit.png" alt="" class="titleIcon" /></a>
            <a class="tipS" title="Remover grupo" href="<?=URL.'usuarios/grupoForm/'.$dados->grp_id?>/delete" onclick="return confirm_delete()"><img style="margin-right: 8px" src="<?=URL?>images/icons/remove.png" alt="" class="titleIcon" /></a>
        </td>
    </tr>
    <? } ?>
    </tbody>
    </table>
</div>