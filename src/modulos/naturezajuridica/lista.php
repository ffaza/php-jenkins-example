<?
use mc\naturezajuridica\natureza;
$ws = new natureza();
?>
<div class="widget" style="margin-top: 57px !important;">
<div class="title">
    <img src="<?=URL?>images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><? echo ucfirst($modulo); ?></h6></div>
<table cellpadding="0" cellspacing="0" border="0" class="display dTable">
    <thead>
        <tr>
            <th><?=utf8_decode("Código")?></th>
            <th>Natureza <?=utf8_decode("Jurídica")?></th>
        </tr>
    </thead>
    <tbody>
        <?
        $count=0;
        $db::$conn->execute($ws->selectAll());
        while($dds = $db::$conn->getObject())
        {
        ?>
            <tr class="gradeA">
                <td class="center"><?=$dds->CO_NATUREZA?></td>
                <td ><?=$dds->NO_NATUREZA?></td>
            </tr>
        <? } ?>
    </tbody>
</table>
</div>