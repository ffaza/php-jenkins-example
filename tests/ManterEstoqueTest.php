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
 */
class ManterEstoqueTest extends PHPUnit_Extensions_Selenium2TestCase
{

//    public function createApplication()
//    {
//        return require __DIR__ . "/../../tests/app.php";
//    }

//    //put your code here
//    protected function setUp()
//    {
//        $this->setBrowser('chrome');
//        $this->setBrowserUrl('http://debug.store.sbcp.live/');
//    }

    /**
     * @test                                          
     */
    public function cadastrarNovoLote()
    {
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        $this->byLinkText("Novo Lote")->click();
        sleep(3);
        //efetuado cadastro de uma quantidade diferenciada para conseguir recuperar posteriormente na grid, pois não existe um 
        //identificador único apenas o gerado via banco de dados e apresentado para usuário na grid
        $this->byId("lote-quantidade")->value("1869");
        //checar se todos os inputs foram preenchidos
        $this->assertEquals('1869', $this->byId("lote-quantidade")->value());
        sleep(2);
        //preencher a data de cadastro
        $this->byCssSelector("i.glyphicon.glyphicon-calendar")->click();
        $this->byXPath("html/body/div[2]/div[1]/table/tbody/tr[4]/td[6]")->click();
        sleep(2);
        //verificar se houve alteracoes nos nomes dos campos na tela
        $this->byXPath("//button[@type='submit']")->click();
        sleep(3);
        //checar se foi apresentado alguma mensagem erro que impeça cadastro, como campos obrigatórios nulos
        $mensagemApresentadaNaTela = $this->checarMensagemDeValidacaoCamposNulo();
        $mensagemApresentadaNaTela = $mensagemApresentadaNaTela == null ? 0 : $mensagemApresentadaNaTela;
        $this->assertNotEquals(count($mensagemApresentadaNaTela), 0, "Campos obrigatórios na tela não foram preenchidos:" . " : " . print_r($mensagemApresentadaNaTela, true));
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
    public function verificarAlteracoesDeCamposNaTelaCadastrarNovoLote()
    {
        /* este cenario verifica se o total de campos de preenchimentos na tela foram alterados, caso tenha ocorrido a
         * insercao de novos ou a até mesmo retiradas. A checagem é efetuada validando se os nomes antigos confere com os atuais
         */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        $this->byLinkText("Novo Lote")->click();
        sleep(3);
        /* pegar todos os nomes dos campos da tela 
          a validacao esta sendo realizada dessa forma pois não foi encontrado nenhuma maneira de pegar todos os componentes da tela, como
         * input's , combobox entre outros
         */
        $todosOsNomesDosCamposAntigosConcatenados = "QuantidadeDatadeentradaSalvar";
        $nomeTodosCamposAtuaisTela = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]")->text();
        //retirar quebra de linha entre o nomes do campos
        $nomeTodosCamposAtuaisTela = str_replace("\n", ' ', $nomeTodosCamposAtuaisTela);
        //retirar espacos
        $nomeTodosCamposAtuaisTela = str_replace(" ", "", $nomeTodosCamposAtuaisTela);
        $this->assertEquals($nomeTodosCamposAtuaisTela, $todosOsNomesDosCamposAntigosConcatenados, "Houve alterações dos campos na tela:" . " : " . print_r($nomeTodosCamposAtuaisTela, true));
    }

    /**
     * @test
     */
    public function verificarAlteracoesNosBotoesSuperiorEhInferiorTelaNovoLote()
    {
        /* cenario verificar se houve adicao ou retirada de  botões na parte superior ou inferior da tela.
          A checagem eh efetuada verificando os nome dos botões na parte inferior e superior
         */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        $this->byLinkText("Novo Lote")->click();
        sleep(3);
        /* pegar nomenclatura dos botões parte superior da ela, a checagem eh realizada pelo nome, pois nao foi encontrado método
          para pegar os componentes da tela */
        $nomesDosBotoesParteSuperiorTelaAntigo = "Voltar";
        $nomeDosBotoesParteSuperiorTela = $this->byXPath("html/body/div[1]/div/section[2]/div/p/a")->text();
        $this->assertEquals($nomesDosBotoesParteSuperiorTelaAntigo, $nomeDosBotoesParteSuperiorTela, "Houve alterações dos botões na parte superior da tela:" . " Nomes Antigos: " . print_r($nomesDosBotoesParteSuperiorTelaAntigo, true)
                . " Novos Nomes: " . print_r($nomeDosBotoesParteSuperiorTela, true));
        /* pegar nomenclatura dos botões parte inferior da ela, a checagem eh realizada pelo nome, pois nao foi encontrado método
          para pegar os componentes da tela */
        $nomesDosBotoesParteInferiorTelaAntigo = "Salvar";
        $nomeDosBotoesParteInferiorTela = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]/form/div[3]/div/button")->text();
        $this->assertEquals($nomesDosBotoesParteInferiorTelaAntigo, $nomeDosBotoesParteInferiorTela, "Houve alterações dos botões na parte superior da tela:" . " Nomes Antigos: " . print_r($nomesDosBotoesParteInferiorTelaAntigo, true)
                . " Novos Nomes: " . print_r($nomeDosBotoesParteInferiorTela, true));
    }

    /**
     * @test
     */
    public function verificarAlteracoesNoCabecalhoTelaCadastrarNovoLote()
    {
        /* cenario verificar se houve alterações no cabeçalho da tela, como nome entre outros
          A checagem eh efetuada verificando os nome dos campos */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        $this->byLinkText("Novo Lote")->click();
        sleep(3);
        /* pegar nomenclatura encontrada no cabeçalho superior da tela, a checagem eh realizada pelo nome, pois nao foi encontrado método
          para pegar os componentes da tela */
        $nomeDosCamposCabecalhoAntigo = "Novo Lote";
        $nomeDosCamposCabecalhoAtual = $this->byXPath("html/body/div[1]/div/section[1]/h1")->text();
        //retirar quebra de linha entre o nomes do campos
        $nomeDosCamposCabecalhoAtual = str_replace("\n", ' ', $nomeDosCamposCabecalhoAtual);
        //retirar espacos
        //$nomeDosCamposCabecalhoAtual = str_replace(" ", "", $nomeDosCamposCabecalhoAtual);
        $this->assertEquals($nomeDosCamposCabecalhoAntigo, $nomeDosCamposCabecalhoAtual, "Houve alterações no cabeçalho na tela como nome entre outros:" . " Nomes Antigos: " . print_r($nomeDosCamposCabecalhoAntigo, true)
                . " Novos Nomes: " . print_r($nomeDosCamposCabecalhoAtual, true));
    }

    /**
     * @test
     */
    public function cancelarEdicaoLote()
    {
        /* efetuado o cancelamento de edicao do registro cadastrado no cenario "cadastrarNovoLote" 
          o cancelamento  é efetuado quando usuário clica no votão voltar.
         */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        // recuperar o elemento cadastrado anteriormente no cenário "cadastrarNovoLote"
        $quantidadeParaBuscarNaGrid = '1869';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($quantidadeParaBuscarNaGrid);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/tbody/tr[" . $posicaoDoElementoGrid . "]/td[4]/a[1]/i")->click();
        sleep(5);
        //clicar no botao "voltar" na tela, indicando a desitencia da edicao
        $this->byXPath("html/body/div[1]/div/section[2]/div/p/a")->click();
        //clicar no botao "voltar" na tela, indicando a desitencia da edicao
        $this->byXPath("html/body/div[1]/div/section[2]/div/p/a")->click();
    }

    /**
     * @test
     */
    public function editarLote()
    {
        /* efetuado o cancelamento de edicao do registro cadastrado no cenario "cadastrarNovoLote" 
          o cancelamento  é efetuado quando usuário clica no votão voltar.
         */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        $quantidadeParaBuscarNaGrid = '1869';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($quantidadeParaBuscarNaGrid);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/tbody/tr[" . $posicaoDoElementoGrid . "]/td[4]/a[1]/i")->click();
        sleep(5);
        $numeroAntesDaEdicao = $this->byXPath("//div[1]/div/section[2]/div/div/div/div/div[2]/form/div[1]/input")->value();
        $this->byXPath("//div[1]/div/section[2]/div/div/div/div/div[2]/form/div[1]/input")->clear();
        $this->byXPath("//div[1]/div/section[2]/div/div/div/div/div[2]/form/div[1]/input")->value("1868");
        $numeroDepoisDaEdicao = $this->byXPath("//div[1]/div/section[2]/div/div/div/div/div[2]/form/div[1]/input")->value();
        $this->assertNotEquals($numeroAntesDaEdicao, $numeroDepoisDaEdicao, "Não Houve alteração do valor:" . "Valor Antigo  :" . print_r($numeroAntesDaEdicao, true)
                . " " . "Valor nome :" . "  " . print_r($numeroDepoisDaEdicao, true));

        //checar se o campo data entrada foi preenchido clicar na opção do calendário
        $this->byCssSelector("i.glyphicon.glyphicon-calendar")->click();
        $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]/form/div[3]/div/button")->click();
        sleep(5);
    }

    /**
     * @test
     */
    public function cancelarExclusao()
    {
        /* efetuado o cancelamento de edicao do registro alterado no cenario "editarLote" 
          o cancelamento  é efetuado quando usuário clica no votão voltar.
         */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();

        $quantidadeParaBuscarNaGrid = '1868';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($quantidadeParaBuscarNaGrid);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/tbody/tr[" . $posicaoDoElementoGrid . "]/td[4]/a[2]/i")->click();
        sleep(5);
        //checar se foi apresentado a popup de exclusao de registro pegar o texto apresentado eh comparar com o texto antigo
        $textoAtual = $this->byXPath("html/body/div[3]/h2")->text();
        $textoAntigo = "Apagar Lote?";
        $this->assertEquals($textoAntigo, $textoAtual, "Mensagem de apagar registro foi alterada ou elemento não foi encontrado!"
                . "Mensagem Antiga" . ":" . $textoAntigo . "Mensagem Atual" . ":" . $textoAtual);
        //confirmar o click no botao "cancelar"
        $this->byCssSelector("button.cancel")->click();
        sleep(3);
    }

    /**
     * @test
     */
    public function verificarAlteracoesNoTotalDeColunasDaGrid()
    {
        /* esse cenario checa se as colunas na grid foram alteradas tanto o total de colunas como nomenclatura
         * procedimento eh executando buscando registro alterado no cenario "editarLote" em seguida chegando os campos apresentados
         */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        sleep(5);
        $quantidadeParaBuscarNaGrid = '1868';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($quantidadeParaBuscarNaGrid);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        //nesse caso não tem como buscar o elemento na grid, checamos apenas se foi encontrado 
        //para verificar os campos na grid
        $this->assertNotEquals($posicaoDoElementoGrid, 0, "Quantidade de lote não encontrada!");
        //variavel que recebe total de colunas atual na grid
        $totalColunasAntigoNaGrid = '3';
        //nome das colunas atual na grid
        $nomeColunasAntigasNaGrid = array("Id", "Quantidade", "Data de entrada");
        $totalColunasAtualGrid = $this->retornarTotalDeColunasGrid($totalColunasAntigoNaGrid);
        //checar se o total de colunas foi alterado
        $this->assertEquals($totalColunasAntigoNaGrid, $totalColunasAtualGrid, "Total de colunas na grid foi alterado" .
                " Total atual:" . " : " . $totalColunasAtualGrid . "Total antigo:" . " : " . $totalColunasAntigoNaGrid);
        //checar se houve alterações no nome dos campos na grid
        $nomeNaoEncontrados = array();
        $nomeNaoEncontrados[] = $this->verificarAlteracaoNomeDasColunasNaGrid($nomeColunasAntigasNaGrid);
        //checar se o total de colunas foi alterado
        $this->assertNotEquals(count($nomeNaoEncontrados), 0, "O nome das colunas foram alterados" .
                " Nomes Antigos :" . " : " . print_r($nomeColunasAntigasNaGrid, true) . "Novos nomes não encontrados:" . " : " . print_r($nomeNaoEncontrados, true));
    }

    /**
     * @test
     */
    public function verificarAlteracaoDasFuncionalidadesNaGrid()
    {
        /* cenario verificar se houve alteracoes no numero de funcionalidades da grid exemplo excluir, cancelar entre outros
          para checar essa ocorrencia é procurado o registro cadastrado no cenario "cadastrarNovoLote" e checado se o numero de funcionalidades
         * no campo "acao" da grid foram alterados
         */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        sleep(5);
        $quantidadeParaBuscarNaGrid = '1868';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($quantidadeParaBuscarNaGrid);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        //checar as funcionalidades disponivel na tela, atualmente consta tota de 01(Editar), nao é possível excluir lote
        $totalFuncionalidadeCampoAcaoGrid = '2';
        //comparar com o total disponivel na grid atualmente
        $totalAtualFuncionalidadeGrid = $this->retornarTotalDeFuncionalidadesCampoAcaoGrid($totalFuncionalidadeCampoAcaoGrid, $posicaoDoElementoGrid);
        //checar o valor atual e antigo 
        $this->assertEquals($totalFuncionalidadeCampoAcaoGrid, $totalAtualFuncionalidadeGrid, "Total de funcionalidades na grid foram alteradas" . " Total atual:" . " : " . $totalAtualFuncionalidadeGrid . "Total antigo:" .
                " : " . $totalFuncionalidadeCampoAcaoGrid);
    }

    /**
     * @test
     */
    public function excluirEstoque()
    {
        /* efetuado o cancelamento de edicao do registro cadastrado no cenario "editarLote" 
          o cancelamento  é efetuado quando usuário clica no votão voltar.
         */

        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//div[1]/aside/section[1]/ul/li[6]/a")->click();
        $quantidadeParaBuscarNaGrid = '1868';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($quantidadeParaBuscarNaGrid);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/tbody/tr[" . $posicaoDoElementoGrid . "]/td[4]/a[2]/i")->click();
        sleep(5);
        //checar se foi apresentado a popup de exclusao de registro pegar o texto apresentado eh comparar com o texto antigo
        $textoAtual = $this->byXPath("html/body/div[3]/h2")->text();
        $textoAntigo = "Apagar Lote?";
        $this->assertEquals($textoAntigo, $textoAtual, "Mensagem de apagar registro foi alterada ou elemento não foi encontrado!"
                . "Mensagem Antiga" . ":" . $textoAntigo . "Mensagem Atual" . ":" . $textoAtual);
        //confirmar o click no botao "cancelar"
        $this->byCssSelector("button.confirm")->click();
        sleep(3);
    }

    /*     * ***************************************************************************************************************************** */
    /* FUNCTION (FUNCOES) AUXILIARES UTLIZADAS DENTRO DOS CENARIOS                                                                        */
    /*     * ***************************************************************************************************************************** */

    public function verificarAlteracaoNomeDasColunasNaGrid($colunasAtuaisNaGrid)
    {
        $nomeNaoEncontrados = array();
        //a checagem eh efetuada utilizando total de elementos disponiveis na grid
        $totalAtual = count($colunasAtuaisNaGrid) + 1;
        for ($i = 1; $i <= count($colunasAtuaisNaGrid); $i++) {

            $nomeColunaAtualGrid = NULL;
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                $nomeColunaAtualGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div/div/div[3]/table/thead/tr/th[" . $i . "]/a")->text();
            } catch (Exception $exc) {
                break;
                echo $exc->getTraceAsString();
            }
            //checar os nome dos elementos se sao os mesmos na tela ou ocorreram alteracoes
            if (!(in_array($nomeColunaAtualGrid, $colunasAtuaisNaGrid))) {
                $nomeNaoEncontrados [] = $nomeColunaAtualGrid;
                break;
            }
        }
        return $nomeNaoEncontrados;
    }

    public function retornarTotalDeColunasGrid($colunasAtuaisNaGrid)
    {
        //a checagem eh efetuada utilizando total de elementos disponiveis na grid
        $totalgrid = 0;
        $totalAtual = ($colunasAtuaisNaGrid + 1);
        for ($i = 1; $i <= $totalAtual; $i++) {
            $nomeColunaAtualGrid = NULL;
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                $nomeColunaAtualGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/thead/tr/th[" . $i . "]/a")->text();
                $totalgrid++;
            } catch (Exception $exc) {
                break;
                echo $exc->getTraceAsString();
            }
        }
        return $totalgrid;
    }

    public function retornarTotalDeFuncionalidadesCampoAcaoGrid($totalAtual, $posicaoDoElemento)
    {
        //a checagem eh efetuada utilizando o contador do total de funcionalidades atual no campo  grid
        $totalAtual = $totalAtual + 1;
        for ($i = 1; $i <= $totalAtual; $i++) {
            $funcionalidadeGrid = NULL;
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                $funcionalidadeGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[4]/a[" . $i . "]/i")->text();
            } catch (Exception $exc) {
                break;
                echo $exc->getTraceAsString();
            }
            if ($funcionalidadeGrid) {
                break;
            }
        }
        return ($i - 1);
    }

    public function checarMensagemDeValidacaoCamposNulo()
    {

        //as mensagens de checagem de campo obrigatorio constam em "div" diferentes, sendo necessario
        //fazer checagem 
        //a checagem eh efetuada utilizando o contador do total de funcionalidades atual na grid
        $totalCamposPreenchimento = 2;
        //verificar se o total de campos de preenchimento foi alterado
        //$this->assertNotEquals(2, 1, "total de campos de prenchimento da ela foram alterados!");
        $mensagemApresentadaNaTela = array();
        $mensagemApresentadaNaTela = NULL;
        for ($i = 1; $i <= $totalCamposPreenchimento; $i++) {
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                if ($i > 1) {
                    $mensagemApresentadaNaTela [] = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]/form/div[" . $i . "]/div[2]")->text();
                }
                $mensagemApresentadaNaTela [] = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]/form/div[" . $i . "]/div")->text();
            } catch (Exception $exc) {

                echo $exc->getTraceAsString();
            }
        }
        return $mensagemApresentadaNaTela;
    }

    public function retornaPosicaoEhPaginaDoElementoParaEdicao($nomeId)
    {

        sleep(5);
        $totalGeralEstoqueCadastrado = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[1]/div[1]/div/b[2]")->text();
        $achou = 0;
        $cont = 2;
        do {
            //limpar as variaveis
            $totalGeralDeEstoqueParaPaginacao = 0;
            $totalEstoqueNaGrid = 0;
            $totalAtualNaGrid = 0;
            //pegar total de grupos criados disponiveis na grid
            $totalEstoqueNaGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[1]/div[1]/div/b[1]")->text();
            //pegar os dois ultimos caracteres na tela
            $totalGeralDeEstoqueParaPaginacao = (int) substr($totalEstoqueNaGrid, -2);
            //pegar os dois primeiros caracteres da string que corresponde o valor total de elementos da grid
            $totalEstoqueNaGrid = (int) substr($totalEstoqueNaGrid, 0, 2);
            $totalAtualNaGrid = (int) ((trim($totalGeralDeEstoqueParaPaginacao) - trim($totalEstoqueNaGrid)) + 1);
            $achou = $this->procurarElementoNaGrid($totalAtualNaGrid, $nomeId);
            sleep(5);
            if ($achou != 0) {
                break;
            } else {
                $cont++;
                sleep(3);
                $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[4]/div[1]/ul/li[" . $cont . "]/a")->click();
            }
        } while ($achou == 0);
        $paginaEhPosicaoGrid = array($cont, $achou);
        return $paginaEhPosicaoGrid;
    }

    public function procurarElementoNaGrid($totalEstoqueNaGrid, $quantidadeProcurada)
    {
        $achou = 0;
        for ($i = 1; $i <= $totalEstoqueNaGrid; $i++) {
            sleep(1);
            $quantidadeDeEstoqueGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[3]/table/tbody/tr[" . $i . "]/td[2]")->text();


            if (trim($quantidadeDeEstoqueGrid) == trim($quantidadeProcurada)) {
                $achou = $i;
                break;
            }
        }

        return $achou;
    }

    public function retornarUltimoIdDaGrid($nomeId)
    {
        sleep(5);
        $totalGeralEstoqueCadastrado = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[1]/div[1]/div/b[2]")->text();
        $achou = 0;
        $cont = 2;
        do {
            //limpar as variaveis
            $totalGeralDeEstoquePaginacao = 0;
            $totalRelatorioNaGrid = 0;
            $totalAtualNaGrid = 0;
            //pegar total de grupos criados disponiveis na grid
            $totalEstoqueNaGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[1]/div[1]/div/b[1]")->text();
            //pegar os dois ultimos caracteres na tela
            $totalGeralDeEstoqueParaPaginacao = (int) substr($totalEstoqueNaGrid, -2);
            //pegar os dois primeiros caracteres da string que corresponde o valor total de elementos da grid
            $totalEstoqueNaGrid = (int) substr($totalEstoqueNaGrid, 0, 2);
            $totalAtualNaGrid = (int) ((trim($totalGeralDeEstoqueParaPaginacao) - trim($totalEstoqueNaGrid)) + 1);
            if ($totalAtualNaGrid < 20) {
                break;
            } elseif ($totalGeralDeEstoqueParaPaginacao == $totalGeralEstoqueCadastrado) {
                break;
            } else {
                $cont++;
                $this->byXPath("html/body/div[1]/div/section[2]/div/div[2]/div/div[4]/div[1]/ul/li[" . $cont . "]/a")->click();
            }
        } while ($achou == 0);
        return $totalAtualNaGrid;
    }

}
