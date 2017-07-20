<?php

$path = '/../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase.php';
if (file_exists($path)) {
    require_once $path;
} else {
    require_once dirname(__FILE__) . '/' . $path;
}
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
class ManterBancoDadosEmailTest extends PHPUnit_Extensions_Selenium2TestCase
{
//
    public function createApplication()
    {
        return require __DIR__ . "../src/app.php";
        
    }

//    //put your code here
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://debug.store.sbcp.live/');
    }

    /**
     * @test                                          
     */
    public function cadastrarEmail()
    {
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        $this->byLinkText("Novo Registro")->click();
        $this->byId("newsletter-nome")->value("Ricardo");
        $this->byId("newsletter-email")->click();
        $this->byId("newsletter-email")->value("teste@mastercase.com.br");
        $FuncionalidadeNome = $this->byId("newsletter-nome")->value();
        $FuncionalidadeEmail = $this->byId("newsletter-email")->value();
        $this->assertEquals('Ricardo', $FuncionalidadeNome);
        $this->assertEquals('teste@mastercase.com.br', $FuncionalidadeEmail);
        /* checar  se foram adicionados novos campos na tela, como nao eh possivel pegar todos os inputs da tela 
          a validacao eh realizada pegando todos os campos textos do form, os campos nome e e-mail */
        $camposlNaTela = "Nome E-mail Salvar";
        $camposTextoDoFormTelaAtual = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]")->text();
        //retirar quebra de linha
        $camposTextoDoFormTelaAtual = str_replace("\n", ' ', $camposTextoDoFormTelaAtual);
        $this->assertEquals($camposlNaTela, $camposTextoDoFormTelaAtual, "Erro total de campos na tela atual não confere:" . " " . $camposTextoDoFormTelaAtual);
        sleep(5);
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        /* checar se houve algum mensagem de erro que impeca o cadastro, exemplo e-mail ja cadastrado, caso essa informacao nao seja
          verificado o teste passa normalmente */
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div/div/div[2]/form/div[2]/div[2]/div");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        if ($mensagemErro) {
            $this->checarMensagemDeErro($mensagemErro);
        }
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
    public function cancelarEdicao()
    {
        /* efetuado o cancelamento de edicao do registro cadastrado no cenario "cadastrarEmail" */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar o nome do e-mail cadastrado no cenario anterior
        $nomeDoEmailParaEdicao = 'teste@mastercase.com.br';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmailParaEdicao);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElementoGrid . "]/td[4]/a[1]/i")->click();
        sleep(5);
        //clicar no botao "voltar" na tela, indicando a desitencia da edicao
        $this->byXPath("html/body/div[1]/div/section[2]/div/p/a")->click();
    }

    /**
     * @test
     */
    public function editarEmail()
    {
        /* A edicao eh realizada do registro anterior, gravado no cenario acima "cadastrar-E-mail" */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar o nome do e-mail cadastrado no cenario anterior
        $nomeDoEmailParaEdicao = 'teste@mastercase.com.br';
        /* percorrer todos os elementos ate encontrar o grupo para edicao, pegar o numero da pagina e posicao na tela */
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmailParaEdicao);
        $numeroDaPaginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElementoGrid = (String) $paginaEhPosicaoElemento[1];
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElementoGrid . "]/td[4]/a[1]/i")->click();
        sleep(5);
        //pegar o nome antes da edicao
        $nomeEmailAntesDeEditar = $this->byId("newsletter-nome")->value();
        //limpar o nome atual 
        sleep(5);
        $this->byId("newsletter-nome")->clear();
        //adicionar o novo nome  
        $this->byId("newsletter-nome")->value("Carlos Henrique Fonseca de Araujo");
        $nomeEmailAposDeEditar = $this->byId("newsletter-nome")->value();
        sleep(5);
        //agora comparar o antigo nome com o novo certificando que houve a alteracao
        $this->assertNotEquals($nomeEmailAntesDeEditar, $nomeEmailAposDeEditar, "Não Houve alteração do nome:" . "Nome Antigo  :" . print_r($nomeEmailAntesDeEditar, true)
                . " " . "Novo nome :" . "  " . print_r($nomeEmailAposDeEditar, true));
        sleep(5);
        $this->byXPath("//button[@type='submit']")->click();
        sleep(5);
        /* checar se houve algum mensagem de erro que impeca o cadastro, exemplo e-mail ja cadastrado, caso essa informacao nao seja
          verificado o teste passa normalmente */
        $mensagemErro = NULL;
        try {
            $mensagemErro = $this->byXPath("/html/body/div/div/section[2]/div/div/div/div/div[2]/form/div[2]/div[2]/div");
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
    public function cancelarExclusao()
    {
        // cancelar a exclusao do registro cadastrado em  "cadastrarEmail"
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar email 
        $nomeDoEmail = 'teste@mastercase.com.br';
        //procurar o elemento da grid e retornar o numero da paginacao e a posicao na grid
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmail);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        //passar o numero da pagina e a posicao em que esta para executar exclusao
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $paginacao . "]/a")->click();
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[4]/a[2]/i")->click();
        sleep(5);
        //checar se foi apresentado a popup de exclusao de registro pegar o texto apresentado eh comparar com o texto antigo
        $textoAtual = $this->byXPath("html/body/div[3]/h2")->text();
        $textoAntigo = "Apagar Registro";
        $this->assertEquals($textoAntigo, $textoAtual, "Mensagem de apagar registro foi alterada ou elemento não foi encontrado!"
                . "Mensagem Antiga" . ":" . $textoAntigo . "Mensagem Atual" . ":" . $textoAtual);
        //confirmar o click no botao "cancelar"
        $this->byCssSelector("button.cancel")->click();
        sleep(3);
    }

    /**
     * @test
     */
    public function verificarAlteracaoDasFuncionalidadesNaGrid()
    {
        /* cenario verificar se houve alteracoes no numero de funcionalidades da grid exemplo excluir, cancelar entre outros
          para checar essa ocorrencia é procurado o registro cadastrado no cenario "cadastrarEmail" e checado se o numero de funcionalidades
         * no campo "acao" da grid foram alterados
         */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar email 
        $nomeDoEmail = 'teste@mastercase.com.br';
        //procurar o elemento da grid e retornar o numero da paginacao e a posicao na grid
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmail);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        //passar o numero da pagina e a posicao em que esta para executar exclusao
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $paginacao . "]/a")->click();
        sleep(5);
        //checar as funcionalidades disponivel tela, atualmente consta tota de 02(Editar;Excluir)
        $totalFuncionalidadeCampoAcaoGrid = '2';
        //comparar com o total disponivel na grid atualmente
        $totalAtualFuncionalidadeGrid = $this->retornarTotalDeFuncionalidadesCampoAcaoGrid($totalFuncionalidadeCampoAcaoGrid, $posicaoDoElemento);
        //checar o valor atual e antigo 
        $this->assertEquals($totalFuncionalidadeCampoAcaoGrid, $totalAtualFuncionalidadeGrid, "Total de funcionalidades na grid foram alteradas" .
                " Total atual:" . " : " . $totalAtualFuncionalidadeGrid . "Total antigo:" . " : " . $totalFuncionalidadeCampoAcaoGrid);
    }

    /**
     * @test
     */
    public function verificarAlteracoesNasColunasDaGrid()
    {
        /* esse cenario checa se as colunas na grid foram alteradas tanto o total de colunas como nomenclatura
         * procedimento eh executando buscando registro cadastrado no cenario "cadastrarEmail" em seguida chegando os campos apresentados
         */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar email 
        $nomeDoEmail = 'teste@mastercase.com.br';
        //procurar o elemento da grid e retornar o numero da paginacao e a posicao na grid
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmail);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        //passar o numero da pagina e a posicao em que esta para executar exclusao
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $paginacao . "]/a")->click();
        sleep(5);
        //variavel que recebe total de colunas atual na grid
        $totalColunasAntigoNaGrid = '3';
        //nome das colunas atual na grid
        $nomeColunasAntigasNaGrid = array("Nome", "E-mail", "Data de Cadastro");
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
    public function excluirEmail()
    {
        //exclusao eh realizada do registro alterado no cenario "editarEmail"
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar email 
        $nomeDoEmail = 'teste@mastercase.com.br';
        //procurar o elemento da grid e retornar o numero da paginacao e a posicao na grid
        $paginaEhPosicaoElemento = array();
        $paginaEhPosicaoElemento = $this->retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmail);
        $paginacao = (String) $paginaEhPosicaoElemento[0];
        $posicaoDoElemento = (String) $paginaEhPosicaoElemento[1];
        //passar o numero da pagina e a posicao em que esta para executar exclusao
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $paginacao . "]/a")->click();
        sleep(5);
        $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[4]/a[2]/i")->click();
        sleep(5);
        //checar se foi apresentado a popup de exclusao de registro pegar o texto apresentado eh comparar com o texto antigo
        $textoAtual = $this->byXPath("html/body/div[3]/h2")->text();
        $textoAntigo = "Apagar Registro";
        $this->assertEquals($textoAntigo, $textoAtual, "Mensagem de apagar registro foi alterada ou elemento não foi encontrado!"
                . "Mensagem Antiga" . ":" . $textoAntigo . "Mensagem Atual" . ":" . $textoAtual);
        //confirmar exclusao do item da tela
        $this->byCssSelector("button.confirm")->click();
        sleep(3);
    }

    /**
     * @test
     */
    public function verificarAlteracoesDeCamposNaTelaPrincipal()
    {
        /* cenario verificar se houve alteracoes dos componentes disponiveis na tela principal
         * como footer reader. A checagem eh efetuada atraves das nomenclaturas dos campos, como nomes de botões, entre outros... */
        $this->url("/admin/site/login");
        $this->byId("loginform-username")->value("jenkins");
        $this->byId("loginform-password")->value("mc102030");
        $this->byName("login-button")->click();
        sleep(5);
        $this->byXPath("//li[5]/a/span")->click();
        sleep(5);
        //pegar as nomenclaturas disponiveis no reader na tela "banco de e-mails"
        $readerAntigo = "Banco de Dados de E-mails Página Inicial Banco de Dados de E-mails";
        $novoReaderTelaBancoEmail = $this->byXPath("html/body/div[1]/div/section[1]")->text();
        $novoReaderTelaBancoEmail = str_replace("\n", ' ', $novoReaderTelaBancoEmail);
        $this->assertEquals($novoReaderTelaBancoEmail, $readerAntigo, "As nomenclaturas do reader da tela foram alterados!" . ":" . "Reader Antigo:" . $readerAntigo . ":" . "Reader Atual:" . $novoReaderTelaBancoEmail);
        //checar se novos botoes foram inclusos na parte superior da tela toda checagem eh efetuada pegando a nomenclatura dos componentes
        $botoesAntigoParteSuperiorTela = "Novo Registro";
        $novosBotoesParteSuperiorTela = $this->byXPath("html/body/div[1]/div/section[2]/div/p")->text();
        $novosBotoesParteSuperiorTela = str_replace("\n", ' ', $novosBotoesParteSuperiorTela);
        $this->assertEquals($botoesAntigoParteSuperiorTela, $novosBotoesParteSuperiorTela, "As nomenclaturas ou botões foram alterados na parte superior da tela!" . ":" . "Antigo:" . $botoesAntigoParteSuperiorTela . ":" . "Reader Atual:" . $novosBotoesParteSuperiorTela);
    }

    /*     * ***************************************************************************************************************************** */
    /* FUNCTION (FUNCOES) AUXILIARES UTLIZADAS DENTRO DOS CENARIOS                                                                         */
    /*     * ***************************************************************************************************************************** */

    public function checarMensagemDeValidacaoCamposNulo()
    {
        //a checagem eh efetuada utilizando o contador do total de funcionalidades atual na grid
        $totalAtual = 1;
        $mensagemApresentadaNaTela = array();
        $mensagemApresentadaNaTela = NULL;
        for ($i = 1; $i <= $totalAtual; $i++) {
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                $mensagemApresentadaNaTela [] = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div/div[2]/form/div[" . $i . "]/div[2]/div")->text();
            } catch (Exception $exc) {
                break;
                echo $exc->getTraceAsString();
            }
            if (count($mensagemApresentadaNaTela) > 0) {
                $totalAtual++;
                //break;
            }
        }
        return $mensagemApresentadaNaTela;
    }

    public function retornarTotalDeFuncionalidadesCampoAcaoGrid($totalAtual, $posicaoDoElemento)
    {
        //a checagem eh efetuada utilizando o contador do total de funcionalidades atual na grid
        $totalAtual = $totalAtual + 1;
        for ($i = 1; $i <= $totalAtual; $i++) {
            $funcionalidadeGrid = NULL;
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                $funcionalidadeGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $posicaoDoElemento . "]/td[4]/a[" . $i . "]/i")->text();
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

    public function retornarTotalDeColunasGrid($colunasAtuaisNaGrid)
    {
        //a checagem eh efetuada utilizando total de elementos disponiveis na grid
        $totalAtual = ($colunasAtuaisNaGrid + 1);
        for ($i = 1; $i <= $totalAtual; $i++) {
            $nomeColunaAtualGrid = NULL;
            /* eh utilizado try catch pois nas situacoes que o elemento nao existe na tela ocorre erro, nao foi localizado até 
             * o momento um metodo para checar se elemento existe ou nao na tela
             */
            try {
                $nomeColunaAtualGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div[3]/table/thead/tr/th[" . $i . "]/a")->text();
                //checar os nome dos elementos se sao os mesmos na tela ou ocorreram alteracoes
            } catch (Exception $exc) {
                break;
                echo $exc->getTraceAsString();
            }
        }
        return ($i - 1);
    }

    public function verificarAlteracaoNomeDasColunasNaGrid($colunasAtuaisNaGrid)
    {
        $nomeNaoEncontrados = array();
        //a checagem eh efetuada utilizando total de elementos disponiveis na grid
        $totalAtual = count($colunasAtuaisNaGrid) + 1;
        for ($i = 1; $i <= count($colunasAtuaisNaGrid); $i++) {
            $nomeColunaAtualGrid = $this->byXPath("html/body/div[1]/div/section[2]/div/div/div/div[3]/table/thead/tr/th[" . $i . "]/a")->text();
            //checar os nome dos elementos se sao os mesmos na tela ou ocorreram alteracoes
            if (!(in_array($nomeColunaAtualGrid, $colunasAtuaisNaGrid))) {
                $nomeNaoEncontrados [] = $nomeColunaAtualGrid;
                break;
            }
        }
        return $nomeNaoEncontrados;
    }

    public function procurarElementoNaGrid($totalEmailNaGrid, $nomeDoEmail)
    {
        $achou = 0;
        for ($i = 1; $i <= $totalEmailNaGrid; $i++) {
            sleep(1);
            $recuperarNomeDoEmail = $this->byXPath("/html/body/div[1]/div/section[2]/div/div/div/div[3]/table/tbody/tr[" . $i . "]/td[2]")->text();

            if (trim($recuperarNomeDoEmail) == trim($nomeDoEmail)) {
                $achou = $i;
                break;
            }
        }

        return $achou;
    }

    public function retornaPosicaoEhPaginaDoElementoParaEdicao($nomeDoEmail)
    {

        sleep(5);
        $totalGeralEmailCadastrado = $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[1]/div[1]/div/b[2]")->text();
        $achou = 0;
        $cont = 2;
        do {
            //limpar as variaveis
            $totalGeralDeEmailParaPaginacao = 0;
            $totalEmailNaGrid = 0;
            $totalAtualNaGrid = 0;
            //pegar total de grupos criados disponiveis na grid
            $totalEmailNaGrid = $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[1]/div[1]/div/b[1]")->text();
            //pegar os dois ultimos caracteres na tela
            $totalGeralDeEmailParaPaginacao = (int) substr($totalEmailNaGrid, -2);
            //pegar os dois primeiros caracteres da string que corresponde o valor total de elementos da grid
            $totalEmailNaGridNaGrid = (int) substr($totalEmailNaGrid, 0, 2);
            $totalAtualNaGrid = (int) ((trim($totalGeralDeEmailParaPaginacao) - trim($totalEmailNaGrid)) + 1);
            $achou = $this->procurarElementoNaGrid($totalAtualNaGrid, $nomeDoEmail);
            sleep(5);
            if ($achou != 0) {
                break;
            } else {
                $cont++;
                //$this->byXPath("/html/body/div/div/section[2]/div/div/div/div/div[4]/div[1]/ul/li[".$cont."]/a")->click();
                $this->byXPath("/html/body/div/div/section[2]/div/div/div/div[4]/div[1]/ul/li[" . $cont . "]/a")->click();
            }
        } while ($achou == 0);
        $paginaEhPosicaoGrid = array($cont, $achou);
        return $paginaEhPosicaoGrid;
    }

    public function checarMensagemDeErro($mensagemErro)
    {

        $this->assertNull($mensagemErro->text(), "Ocorreu erro no cadastro" . " " . print_r($mensagemErro, true));
    }

}
