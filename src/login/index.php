<?
include ("../config.php");

use mc\notify\warning;
use mc\usuarios\login;

$secureHash = filter_input(INPUT_POST,'secureHash',FILTER_SANITIZE_STRING);
if($secureHash && $secureHash==SESSION_HASH)
{
    $us = strtoupper(filter_input(INPUT_POST,'usuario',FILTER_SANITIZE_STRING));
    $pw = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);

    $acesso = new login($us,$pw);
    $db::$conn->execute($acesso->userExists());

    if($db::$conn->getNumRows()>0)
    {
        $retorno = $acesso->getLogin(WS_USER_AUTH);
        if($retorno["retorno"]["status"]==1)
        {

            $dados = $db::$conn->getObject();
            $acesso->setId($dados->SQ_FUNCIONARIO);
            $acesso->setGrupo($dados->grp_id);
            $acesso->setNome($dados->NO_FUNCIONARIO);

            $_SESSION["mc_hash"]        = $secureHash;
            $_SESSION["mc_user_sq"]     = $acesso->getId();
            $_SESSION["mc_user_nome"]   = $acesso->getNome();
            $_SESSION["mc_user_grupo"]  = $acesso->getGrupo();
            $_SESSION["mc_user_login"]  = $us;

            geraLog("Entrou no sistema","",$db);

            echo '<meta http-equiv="refresh" content="0;url='.URL.'" />';
            die();
        }else{
            $msg = explode(":",$retorno["retorno"]["mensagem"]);
            $erro=1;
        }
    }else{
        $msg[1] = "Usuario nao cadastrado.";
        $erro=1;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <title><?=TITLE?></title>
    <? include "../includes/header.php"; ?>
</head>
<body class="nobg loginPage">
<div class="topNav">
    <div class="wrapper">
        <div class="userNav">
            Distribuidor de Processos | JUCEMS
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="loginWrapper">
    <div class="loginLogo"><img src="<?=URL?>images/loginLogo.png" alt="" /></div><br><br><br>
    <div class="widget">
        <div class="title"><img src="<?=URL?>images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Login</h6></div>
        <form action="<?=URL?>login/" id="validate" class="form" method="post">
            <fieldset>
                <input type="hidden" name="secureHash" value="<?=SESSION_HASH?>"/>
                <div class="formRow">
                    <label for="login">Usu&#225;rio:</label>
                    <div class="loginInput"><input type="text" name="usuario" class="validate[required]" id="usuario" /></div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label for="pass">Senha:</label>
                    <div class="loginInput"><input type="password" name="senha" class="validate[required]" id="senha" /></div>
                    <div class="clear"></div>
                </div>
                <div class="loginControl">
                    <!--<div class="rememberMe"><a href="esqueci.php">Esqueci minha senha</a></div>-->
                    <input type="submit" value="Entrar" class="dredB logMeIn" />
                    <div class="clear"></div>
                </div>
            </fieldset>
        </form>
    </div><? if(isset($erro)){new warning(ucfirst(utf8_encode($msg[1])));}?>
</div>
<div id="footer">
    <div  style="margin: 0 auto;width:123px;padding-top: 15px"> <img src="<?=URL?>images/login_mastercase.png" alt=""/>   </div>
    <div class="wrapper"><a href="http://www.mastercase.com.br" title="" target="_blank">Master Case</a> - Copyright &#169; <?=date("Y");?> - Todos os direitos reservados</div>
</div>
</body>
</html>