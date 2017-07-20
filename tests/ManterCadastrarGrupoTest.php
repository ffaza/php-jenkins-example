<?php

//$path = '../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase.php';
//if (file_exists($path)) {
//    require_once $path;
//} else {
//    require_once dirname(__FILE__) . '/' . $path;
//}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manterCadastrarClientePagamento
 *
 * @author Ricardo Koester
 */
class ManterCadastrarGrupoTest extends PHPUnit_Extensions_Selenium2TestCase
{

//    public function createApplication()
//    {
//        return require __DIR__ . "/../../tests/app.php";
//    }
//
//    //put your code here
//    protected function setUp()
//    {
//        $this->setBrowser('chrome');
//        $this->setBrowserUrl('http://debug.store.sbcp.live/');
//    }

    /**
     * @test                                          
     */
    public function criarGrupoComAcessoTotal()
    {
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byCssSelector("li.treeview > a > span")->click();
        sleep(5);
        $this->byLinkText("Grupos")->click();
        $this->byLinkText("Novo Grupo")->click();
        $this->byId("grupo-description")->value("ADMINISTRADOR ALMOXARIFADO SENIOR-16");
        $this->byCssSelector("div.col-md-12 > div.box-header")->click();
        $this->byName("permissao[newsletter]")->click();
        $this->byName("permissao[cliente]")->click();
        $this->byName("permissao[documentos]")->click();
        $this->byName("permissao[entrega]")->click();
        $this->byName("permissao[upload-contrato]")->click();
        $this->byName("permissao[upload-docs]")->click();
        $this->byName("permissao[contrato]")->click();
        $this->byName("permissao[informar-entrega]")->click();
        $this->byName("permissao[grupo]")->click();
        $this->byName("permissao[index]")->click();
        $this->byName("permissao[baixa]")->click();
        $this->byName("permissao[view]")->click();
        $this->byName("permissao[modalexport]")->click();
        $this->byName("permissao[usuario]")->click();
        //certificar que todos os radiobutton foram setado com valor "total" pegar o valor de cada radiobutton
        $FuncionadadeBancoEmais = $this->byName("permissao[newsletter]")->value();
        $FuncionadadeCliente = $this->byName("permissao[cliente]")->value();
        $FuncionadadeDocumento = $this->byName("permissao[documentos]")->value();
        $FuncionadadeEntregaPenCard = $this->byName("permissao[entrega]")->value();
        $FuncionadadeAnexarContrato = $this->byName("permissao[upload-contrato]")->value();
        $FuncionadadeAnexarDocumento = $this->byName("permissao[upload-docs]")->value();
        $FuncionadadeGerarContrato = $this->byName("permissao[contrato]")->value();
        $FuncionadadeInformarEntrega = $this->byName("permissao[informar-entrega]")->value();
        $FuncionadadeGrupo = $this->byName("permissao[grupo]")->value();
        $FuncionadadePainel = $this->byName("permissao[index]")->value();
        $FuncionadadeBaixaBoleto = $this->byName("permissao[baixa]")->value();
        $FuncionadadeDetalhesTransacaoCartao = $this->byName("permissao[view]")->value();
        $FuncionadadeExportarDados = $this->byName("permissao[modalexport]")->value();
        $FuncionadadeUsuario = $this->byName("permissao[usuario]")->value();
        //certificar que todos os radiobutton foram setados com valor "total"
        $this->assertContains('total', $FuncionadadeBancoEmais);
        $this->assertEquals('total', $FuncionadadeCliente);
        $this->assertEquals('total', $FuncionadadeDocumento);
        $this->assertEquals('total', $FuncionadadeEntregaPenCard);
        $this->assertEquals('total', $FuncionadadeAnexarContrato);
        $this->assertEquals('total', $FuncionadadeAnexarDocumento);
        $this->assertEquals('total', $FuncionadadeGerarContrato);
        $this->assertEquals('total', $FuncionadadeInformarEntrega);
        $this->assertEquals('total', $FuncionadadeGrupo);
        $this->assertEquals('total', $FuncionadadePainel);
        $this->assertEquals('total', $FuncionadadeBaixaBoleto);
        $this->assertEquals('total', $FuncionadadeDetalhesTransacaoCartao);
        $this->assertEquals('total', $FuncionadadeExportarDados);
        $this->assertEquals('total', $FuncionadadeUsuario);
        //pegar todo o texto disponivel no tbody contendo todas as pemissoes
        $nomeDasPermissoes = "BancodeDadosdeE-mails Clientes DeliveryofPenCards-Documents EntregadePenCards EntregadePenCards-AnexarContrato EntregadePenCards-AnexarDocumentos
        EntregadePenCards-GerarContrato EntregadePenCards-Informarentrega Grupos Painel Relatório-Baixadeboleto Relatório-DetalhesdaTransação-Cartão Relatórios Report-ExportData Usuários";
        //retirar quebra de linha
        $nomeDasPermissoes = str_replace("\n", ' ', $nomeDasPermissoes);
        //retirar os espaços
        $nomeDasPermissoes = str_replace(" ", "", $nomeDasPermissoes);
        $tbodyContendoNomePermissoes = (string) $this->byXPath('/html/body/div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody')->text();
        //retirar quebra de linha
        $tbodyContendoNomePermissoes = str_replace("\n", ' ', $tbodyContendoNomePermissoes);
        //retirar os espaços
        $tbodyContendoNomePermissoes = (string) str_replace(" ", "", $tbodyContendoNomePermissoes);
        //comparar  se houve alteracao em alguma permissao
        $this->assertEquals($nomeDasPermissoes, $tbodyContendoNomePermissoes, "Permissões disponível na tela foram alteradas" . " " . print_r($tbodyContendoNomePermissoes, true));
        //pegar o nome do grupo
        $nomeDoGrupo = $this->byId("grupo-description")->value();
        //checar se ocorreu mensagem de alerta que impeca  cadastro
        sleep(5);
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        //checar se houve algum mensagem de erro que impeca o cadastro
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/div");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        if ($mensagemErro) {
            $this->checarMensagemDeErro($mensagemErro);
        }
        //excluir elemento para evitar erros, pegar o nome do grupo criado
        //pegar total de elementos na grid
        //excluir elemento cadastrado para evitar erro ao rodar o teste novamente
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoGrupo);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[2]/i")->click();
        sleep(5);
        //confirmar exclusao do item da tela
        $this->byCssSelector("button.confirm")->click();
    }

    public function prepareSession()
    {
        $session = parent::prepareSession();
        $this->url('/admin/site/login');

        return $session;
    }

    /**
     * @test
     */
    public function criarGrupoAcessoBancoDadosEmailsComPermissaoCriarApagar()
    {
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byCssSelector("li.treeview > a > span")->click();
        sleep(5);
        $this->byLinkText("Grupos")->click();
        sleep(5);
        $this->byLinkText("Novo Grupo")->click();
        $this->byId("grupo-description")->value("Grupo de Acesso Criar Apagar Banco-15");
        $this->byCssSelector("div.col-md-12 > div.box-header")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[1]/td[3]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[2]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[3]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[4]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[5]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[6]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[7]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[8]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[9]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[10]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[11]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[12]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[14]/td[6]/input")->click();
        $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[15]/td[6]/input")->click();
        //certificar que o radiobutton newsletter foi setado com valor "create" pegar o valor do radiobutton
        $FuncionadadeBancoEmais = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[1]/td[3]/input")->value();
        $FuncionadadeCliente = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[2]/td[6]/input")->value();
        $FuncionadadeDocumento = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[3]/td[6]/input")->value();
        $FuncionadadeEntregaPenCard = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[4]/td[6]/input")->value();
        $FuncionadadeAnexarContrato = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[5]/td[6]/input")->value();
        $FuncionadadeAnexarDocumento = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[6]/td[6]/input")->value();
        $FuncionadadeGerarContrato = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[7]/td[6]/input")->value();
        $FuncionadadeInformarEntrega = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[8]/td[6]/input")->value();
        $FuncionadadeGrupo = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[9]/td[6]/input")->value();
        $FuncionadadePainel = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[10]/td[6]/input")->value();
        $FuncionadadeBaixaBoleto = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[11]/td[6]/input")->value();
        $FuncionadadeDetalhesTransacaoCartao = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[12]/td[6]/input")->value();
        $FuncionadadeExportarDados = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[14]/td[6]/input")->value();
        $FuncionadadeUsuario = $this->byXPath("//div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody/tr[15]/td[6]/input")->value();
        //certificar que todos os radiobutton foram setados com valor "create"
        $this->assertEquals('create', $FuncionadadeBancoEmais);
        $this->assertEquals('noaccess', $FuncionadadeCliente);
        $this->assertEquals('noaccess', $FuncionadadeDocumento);
        $this->assertEquals('noaccess', $FuncionadadeEntregaPenCard);
        $this->assertEquals('noaccess', $FuncionadadeAnexarContrato);
        $this->assertEquals('noaccess', $FuncionadadeAnexarDocumento);
        $this->assertEquals('noaccess', $FuncionadadeGerarContrato);
        $this->assertEquals('noaccess', $FuncionadadeInformarEntrega);
        $this->assertEquals('noaccess', $FuncionadadeGrupo);
        $this->assertEquals('noaccess', $FuncionadadePainel);
        $this->assertEquals('noaccess', $FuncionadadeBaixaBoleto);
        $this->assertEquals('noaccess', $FuncionadadeDetalhesTransacaoCartao);
        $this->assertEquals('noaccess', $FuncionadadeExportarDados);
        $this->assertEquals('noaccess', $FuncionadadeUsuario);
        //pegar todo o texto disponivel no tbody contendo todas 
        //as permissoes da forma de texto
        $nomeDasPermissoes = "BancodeDadosdeE-mails Clientes DeliveryofPenCards-Documents EntregadePenCards EntregadePenCards-AnexarContrato EntregadePenCards-AnexarDocumentos
        EntregadePenCards-GerarContrato EntregadePenCards-Informarentrega Grupos Painel Relatório-Baixadeboleto Relatório-DetalhesdaTransação-Cartão Relatórios Report-ExportData Usuários";
        //retirar quebra de linha
        $nomeDasPermissoes = str_replace("\n", ' ', $nomeDasPermissoes);
        //retirar os espaços
        $nomeDasPermissoes = str_replace(" ", "", $nomeDasPermissoes);
        $tbodyContendoNomePermissoes = (string) $this->byXPath('/html/body/div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody')->text();
        //retirar quebra de linha
        $tbodyContendoNomePermissoes = str_replace("\n", ' ', $tbodyContendoNomePermissoes);
        //retirar os espaços
        $tbodyContendoNomePermissoes = (string) str_replace(" ", "", $tbodyContendoNomePermissoes);
        //comparar  se houve alteracao em alguma permissao
        $this->assertEquals($nomeDasPermissoes, $tbodyContendoNomePermissoes, "Total de permissões disponível na tela foram alteradas" . " " . print_r($tbodyContendoNomePermissoes, true));
        //pegar o nome do grupo
        $nomeDoGrupo = $this->byId("grupo-description")->value();
        //checar se ocorreu mensagem de alerta que impeca  cadastro
        sleep(5);
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        //checar se houve algum mensagem de erro que impeca o cadastro
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/div");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        if ($mensagemErro) {
            $this->checarMensagemDeErro($mensagemErro);
        }
    }

    /**
     * @test
     */
    public function editarNomeDoGrupo()
    {
        // a edicao sera efetuada para grupo cadastro no cenario criarGrupoAcessoBancoDadosEmailsComPermissaoCriarApagar()
        //cadastrar um grupo
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byLinkText("Administração")->click();
        sleep(5);
        $this->byLinkText("Grupos")->click();
        //pegar nome do grupo cadastrado no cenario anterior
        sleep(5);
        $nomeDoGrupoParaEdicao = 'Grupo de Acesso Criar Apagar Banco-15';
        //percorrer todos os elementos ate encontrar o grupo para edicao
        //clicar no elemento encontrado para edicao
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoGrupoParaEdicao);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[1]/i")->click();
        sleep(5);
        $nomeGrupoAntesDeEditar = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/form/div[1]/div[1]/input")->value();
        //limpar o nome atual 
        sleep(5);
        $this->byId("grupo-description")->clear();
        //adicionar o novo nome  
        $this->byId("grupo-description")->value("Televendas");
        $nomeGrupoAposDeEditar = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/form/div[1]/div[1]/input")->value();
        sleep(5);
        //agora comparar o antigo nome com o novo certificando que houve a alteracao
        $this->assertNotEquals($nomeGrupoAntesDeEditar, $nomeGrupoAposDeEditar, "Não houve alteração do nome" . " " . "Nome antes da edição é :" . " " . print_r($nomeGrupoAntesDeEditar, true)
                . " " . "Nome após a edição é :" . " " . print_r($nomeGrupoAposDeEditar, true));
        sleep(5);
        //pegar novo nome do grupo
        $novoNomeDoGrupo = $this->byId("grupo-description")->value();
        //checar se ocorreu mensagem de alerta que impeca o cadastro
        sleep(5);
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/div");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        if ($mensagemErro) {
            $this->checarMensagemDeErro($mensagemErro);
        }
        //excluir elemento para evitar erros, pegar o nome do grupo criado
        //pegar total de elementos na grid
        //excluir elemento cadastrado para evitar erro ao rodar o teste novamente
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($novoNomeDoGrupo);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[2]/i")->click();
        sleep(5);
        //confirmar exclusao do item da tela
        $this->byCssSelector("button.confirm")->click();
    }

    /**
     * @test
     */
    public function alterarPermissaoClienteAcessoTotalParaCriarApagar()
    {
        //alterar permissao do grupo cadastrado no cenario  criarGrupoComAcessoTotal()
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byLinkText("Administração")->click();
        sleep(5);
        //criar novo grupo
        $this->byLinkText("Grupos")->click();
        $this->byLinkText("Novo Grupo")->click();
        $this->byId("grupo-description")->value("Ativacao de Pen Card TESTE LUCIANA FAZAN_77");
        $this->byName("permissao[cliente]")->click();
        //pegar o nome do grupo criado
        $nomeDoGrupo = $this->byId("grupo-description")->value();
        //clicar em salvar
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        //checar se nao houve algum erro que impeca o cadastro
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/div");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        if ($mensagemErro) {
            $this->checarMensagemDeErro($mensagemErro);
        }
        $nomeGrupoTest = "Ativacao de Pen Card TESTE LUCIANA FAZAN_77";
        //procurar elemento na grid para edicao 
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeGrupoTest);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[1]/i")->click();
        sleep(5);
        //alterar para o valor criar e apagar
        $this->byXPath("(//input[@name='permissao[cliente]'])[2]")->click();
        //clicar em salvar
        $this->byXPath("//button[@type='submit']")->click();
        //excluir elemento
        //passar para pagina onde foi encontrado o elemento
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $paginacao . "]/a")->click();
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[2]/i")->click();
        sleep(5);
        //confirmar exclusao do item da tela
        $this->byCssSelector("button.confirm")->click();
        //apos concluir a alteracao do grupo criado é necessario efetuar exclusao do grupo
        //sleep(5);
        //$this->excluirNovoGrupo($nomeGrupoTest);
    }

    /**
     * @test
     */
    public function excluirGrupo()
    {

        $achou = 0;
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byCssSelector("li.treeview > a > span")->click();
        sleep(5);
        $this->byLinkText("Grupos")->click();
        //criar novo grupo
        $this->byLinkText("Novo Grupo")->click();
        $this->byId("grupo-description")->value("Finaceiro Entrega Pen Card");
        $this->byCssSelector("div.col-md-12 > div.box-header")->click();
        $this->byName("permissao[newsletter]")->click();
        $this->byName("permissao[cliente]")->click();
        $this->byName("permissao[documentos]")->click();
        $this->byName("permissao[entrega]")->click();
        $this->byName("permissao[upload-contrato]")->click();
        $this->byName("permissao[upload-docs]")->click();
        $this->byName("permissao[contrato]")->click();
        $this->byName("permissao[informar-entrega]")->click();
        $this->byName("permissao[grupo]")->click();
        $this->byName("permissao[index]")->click();
        $this->byName("permissao[baixa]")->click();
        $this->byName("permissao[view]")->click();
        $this->byName("permissao[modalexport]")->click();
        $this->byName("permissao[usuario]")->click();
        //pegar o nome do grupo criado
        $nomeDoGrupo = $this->byId("grupo-description")->value();
        //clicar em salvar
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        //checar se houve algum mensagem de erro que impeca o cadastro
        //pegar total de grupos criados disponiveis na grid
        //checar total de elementos na grid
        //percorrer todos os elementos ate encontrar o grupo para excluir
        sleep(5);
        //excluir elemento da tela
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoGrupo);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        //passar para pagina onde foi encontrado o elemento
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $paginacao . "]/a")->click();
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[2]/i")->click();
        sleep(5);
        //confirmar exclusao do item da tela
        $this->byCssSelector("button.confirm")->click();
    }

    /*     * ***************************************************************************************************************************** */
    /* FUNCTION (FUNCOES) AUXILIARES UTLIZADAS DENTRO DOS CENARIOS                                                                         */
    /*     * ***************************************************************************************************************************** */

    public function procurarElementoNaGrid($totalGrupoNaGrid, $nomeDoGrupo)
    {
        $achou = 0;
        for ($i = 1; $i <= $totalGrupoNaGrid; $i++) {
            $recuperarNomeDoGrupo = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $i . "]/td[1]")->text();
            if (trim($recuperarNomeDoGrupo) == trim($nomeDoGrupo)) {
                $achou = $i;
                break;
            }
        }

        return $achou;
    }

    public function checarMensagemDeErro($mensagemErro)
    {

        $this->assertNull($mensagemErro->text(), "Ocorreu erro no cadastro" . " " . print_r($mensagemErro, true));
    }

    public function editarGrupoUsandoCadastro($totalGrupoNaGrid, $nomeDoGrupo)
    {

        //para evitar erro ao rodar os testes todos os grupos criados sao editados
        //pegar todos os elementos da grid
        $totalGrupoNaGrid = $this->byXPath('html/body/div[1]/div/section[2]/div/div/div/div/div[1]/div[1]/div/b[2]')->text();
        //checar total de elemento pego da tela
        //percorrer todos os elementos ate encontrar o grupo para excluir
        sleep(5);
        for ($i = 1; $i <= $totalGrupoNaGrid; $i++) {
            $recuperarNomeDoGrupo = $this->byXPath("//div/div/section[2]/div/div/div/div/div[3]/table/tbody/tr[" . $i . "]/td[1]")->text();

            if (trim($recuperarNomeDoGrupo) == trim($nomeDoGrupo)) {
                $achou = $i;
                break;
            }
        }
        //checar se o elemento foi encontrado
        if ($achou != 0) {
            sleep(5);
            $this->byXPath("/html/body/div/div/section[2]/div/div/div/div/div[3]/table/tbody/tr[" . $achou . "]/td[2]/a[1]/i")->click();
            sleep(5);
        }
    }

    public function excluirGrupoUsadoCadastro($totalGrupoNaGrid, $nomeDoGrupo)
    {

        //para evitar erro ao rodar os testes todos os grupos criados sao excluidos
        //pegar todos os elementos da grid
        $totalGrupoNaGrid = $this->byXPath('html/body/div[1]/div/section[2]/div/div/div/div/div[1]/div[1]/div/b[2]')->text();
        //checar total de elemento pego da tela
        //percorrer todos os elementos ate encontrar o grupo para excluir
        for ($i = 1; $i <= $totalGrupoNaGrid; $i++) {
            $recuperarNomeDoGrupo = $this->byXPath("//div/div/section[2]/div/div/div/div/div[3]/table/tbody/tr[" . $i . "]/td[1]")->text();

            if (trim($recuperarNomeDoGrupo) == trim($nomeDoGrupo)) {
                $achou = $i;
                break;
            }
        }
        //checar se o elemento foi encontrado
        if ($achou != 0) {
            sleep(5);
            $this->byXPath("//div/div/section[2]/div/div/div/div/div[3]/table/tbody/tr[" . $achou . "]/td[2]/a[2]/i")->click();
            sleep(5);
            $this->byCssSelector("button.confirm")->click();
        }
    }

    public function retornaPosicaoEhPaginaDoElementoParaEdicao($nomeGrupo)
    {

        sleep(5);
        $totalGeralGrupoCadastrado = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div[1]/div[1]/div/b[1]")->text();
        $achou = 0;
        $cont = 2;
        do {
            //limpar as variaveis
            $totalGeralDeGrupoParaPaginacao = 0;
            $totalGrupoNaGrid = 0;
            $totalAtualNaGrid = 0;
            //pegar total de grupos criados disponiveis na grid
            $totalGrupoNaGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div[1]/div[1]/div/b[1]")->text();
            //pegar os dois ultimos caracteres na tela
            $totalGeralDeGrupoParaPaginacao = (int) substr($totalGrupoNaGrid, -2);
            //pegar os dois primeiros caracteres da string que corresponde o valor total de elementos da grid
            $totalGrupoNaGrid = (int) substr($totalGrupoNaGrid, 0, 2);
            $totalAtualNaGrid = (int) ((trim($totalGeralDeGrupoParaPaginacao) - trim($totalGrupoNaGrid)) + 1);
            $achou = $this->procurarElementoNaGrid($totalAtualNaGrid, $nomeGrupo);
            sleep(5);
            if ($achou != 0) {
                break;
            } else {
                $cont++;
                $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $cont . "]/a")->click();
            }
        } while ($achou == 0);
        $paginaEhPosicaoGrid = array($cont, $achou);
        return $paginaEhPosicaoGrid;
    }

    /*     * ****************************************************************************************************************************************** */
    /* FUNCOES AUXILIARES UTILIZADAS DENTRO DE OUTRAS CLASSES QUANDO NECESSARIOS CADASTRO EFETUADO PASSANDO PARAMETROS****************************************************************** */
    /*     * ********************************************************************************************************************************************** */

    public function cadastrarGrupoUsuarioPorNome($nomeGrupoParaCadastro)
    {
        //executar o fluxo de cadastrar grupo 
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byCssSelector("li.treeview > a > span")->click();
        sleep(5);
        $this->byLinkText("Grupos")->click();
        $this->byLinkText("Novo Grupo")->click();

        $this->byId("grupo-description")->value($nomeGrupoParaCadastro);
        $this->byCssSelector("div.col-md-12 > div.box-header")->click();
        $this->byName("permissao[newsletter]")->click();
        $this->byName("permissao[cliente]")->click();
        $this->byName("permissao[documentos]")->click();
        $this->byName("permissao[entrega]")->click();
        $this->byName("permissao[upload-contrato]")->click();
        $this->byName("permissao[upload-docs]")->click();
        $this->byName("permissao[contrato]")->click();
        $this->byName("permissao[informar-entrega]")->click();
        $this->byName("permissao[grupo]")->click();
        $this->byName("permissao[index]")->click();
        $this->byName("permissao[baixa]")->click();
        $this->byName("permissao[view]")->click();
        $this->byName("permissao[modalexport]")->click();
        $this->byName("permissao[usuario]")->click();
        //certificar que todos os radiobutton foram setado com valor "total" pegar o valor de cada radiobutton
        $FuncionadadeBancoEmais = $this->byName("permissao[newsletter]")->value();
        $FuncionadadeCliente = $this->byName("permissao[cliente]")->value();
        $FuncionadadeDocumento = $this->byName("permissao[documentos]")->value();
        $FuncionadadeEntregaPenCard = $this->byName("permissao[entrega]")->value();
        $FuncionadadeAnexarContrato = $this->byName("permissao[upload-contrato]")->value();
        $FuncionadadeAnexarDocumento = $this->byName("permissao[upload-docs]")->value();
        $FuncionadadeGerarContrato = $this->byName("permissao[contrato]")->value();
        $FuncionadadeInformarEntrega = $this->byName("permissao[informar-entrega]")->value();
        $FuncionadadeGrupo = $this->byName("permissao[grupo]")->value();
        $FuncionadadePainel = $this->byName("permissao[index]")->value();
        $FuncionadadeBaixaBoleto = $this->byName("permissao[baixa]")->value();
        $FuncionadadeDetalhesTransacaoCartao = $this->byName("permissao[view]")->value();
        $FuncionadadeExportarDados = $this->byName("permissao[modalexport]")->value();
        $FuncionadadeUsuario = $this->byName("permissao[usuario]")->value();
        //certificar que todos os radiobutton foram setados com valor "total"
        $this->assertContains('total', $FuncionadadeBancoEmais);
        $this->assertEquals('total', $FuncionadadeCliente);
        $this->assertEquals('total', $FuncionadadeDocumento);
        $this->assertEquals('total', $FuncionadadeEntregaPenCard);
        $this->assertEquals('total', $FuncionadadeAnexarContrato);
        $this->assertEquals('total', $FuncionadadeAnexarDocumento);
        $this->assertEquals('total', $FuncionadadeGerarContrato);
        $this->assertEquals('total', $FuncionadadeInformarEntrega);
        $this->assertEquals('total', $FuncionadadeGrupo);
        $this->assertEquals('total', $FuncionadadePainel);
        $this->assertEquals('total', $FuncionadadeBaixaBoleto);
        $this->assertEquals('total', $FuncionadadeDetalhesTransacaoCartao);
        $this->assertEquals('total', $FuncionadadeExportarDados);
        $this->assertEquals('total', $FuncionadadeUsuario);
        //pegar todo o texto disponivel no tbody contendo todas as pemissoes
        $nomeDasPermissoes = "BancodeDadosdeE-mails Clientes DeliveryofPenCards-Documents EntregadePenCards EntregadePenCards-AnexarContrato EntregadePenCards-AnexarDocumentos
        EntregadePenCards-GerarContrato EntregadePenCards-Informarentrega Grupos Painel Relatório-Baixadeboleto Relatório-DetalhesdaTransação-Cartão Relatórios Report-ExportData Usuários";
        //retirar quebra de linha
        $nomeDasPermissoes = str_replace("\n", ' ', $nomeDasPermissoes);
        //retirar os espaços
        $nomeDasPermissoes = str_replace(" ", "", $nomeDasPermissoes);
        $tbodyContendoNomePermissoes = (string) $this->byXPath('/html/body/div/div/section[2]/div/div/div[2]/div/div/div/form/div[3]/div[3]/div/table/tbody')->text();
        //retirar quebra de linha
        $tbodyContendoNomePermissoes = str_replace("\n", ' ', $tbodyContendoNomePermissoes);
        //retirar os espaços
        $tbodyContendoNomePermissoes = (string) str_replace(" ", "", $tbodyContendoNomePermissoes);
        //comparar  se houve alteracao em alguma permissao
        $this->assertEquals($nomeDasPermissoes, $tbodyContendoNomePermissoes, "Permissões disponível na tela foram alteradas" . " " . print_r($tbodyContendoNomePermissoes, true));
        //pegar o nome do grupo
        $nomeDoGrupo = $this->byId("grupo-description")->value();
        //checar se ocorreu mensagem de alerta que impeca  cadastro
        sleep(5);
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        //checar se houve algum mensagem de erro que impeca o cadastro
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div[2]/div/div/div/div");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        if ($mensagemErro) {
            $this->checarMensagemDeErro($mensagemErro);
        }
        //excluir elemento para evitar erros, pegar o nome do grupo criado
        //pegar total de elementos na grid
        //excluir elemento cadastrado para evitar erro ao rodar o teste novamente
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoGrupo);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[2]/a[2]/i")->click();
        sleep(5);
        //confirmar exclusao do item da tela
        $this->byCssSelector("button.confirm")->click();
    }

}
