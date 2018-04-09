<?
#echo "<pre>";print_r($loadModule);echo "</pre>";
?>
    <div class="logo"><a href="<?=URL?>inicio"><img src="<?=URL?>images/logo.png" alt="" /></a></div>

    <div class="sidebarSep mt0"></div>

<?
/*
?>
    <!-- Search widget -->
    <form action="" class="sidebarSearch">
        <input type="text" name="search" placeholder="buscar..." id="ac" />
        <input type="submit" value="" />
    </form>

    <div class="sidebarSep"></div>
<?
*/
?>



    <!-- Left navigation -->
    <ul id="menu" class="nav">
        <li class="dash "><a href="<?=URL?>inicio" title="" class="active"><span>In&#237;cio</span></a></li>
        <div class="sidebarSep"></div>
        <li class="forms"><a onclick="reloadPage()" href="<?=URL?>processo/lista" title="" ><span>Processos</span></a></li>


        <?php if ($_SESSION["mc_user_grupo"] == 1 || $_SESSION["mc_user_grupo"] == 2){?>
        <li class="forms"><a href="<?=URL?>naturezajuridica/lista" title=""><span>Natureza <?=utf8_decode("Jurídica")?></span></a></li>
        <li class="charts"><a href="#" title="" class="exp"><span>Relat&#243;rios</span><strong>+</strong></a>
            <ul class="sub">
                <li><a href="<?=URL?>relatorios/distribuicaoProcesso" title="" >Distribui&#231;&#227;o de Processos</a></li>
                <li><a href="<?=URL?>relatorios/processoAnalizadoUsuario" title="">Processos Analisados x Usu&#225;rios</a></li>
            </ul>
        </li>
        <li class="tables"><a href="#" title="" class="exp"><span>Usu&#225;rios</span><strong>+</strong></a>
            <ul class="sub">
                <li><a href="<?=URL?>usuarios/lista" title="">Usu&#225;rios</a></li>
                <?php /*<li><a href="<?=URL?>usuarios/grupo" title="">Grupo de Usuários</a></li> */?>
            </ul>
        </li>
        <?php }?>
    </ul>
