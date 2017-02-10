<?php

//$path = 'vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase.php';
//if (file_exists($path)) {
//    require_once $path;
//} else {
//    require_once dirname(__FILE__) . '/' . $path;
//}

class ManterUsuarioTest extends PHPUnit_Extensions_Selenium2TestCase {
    
    
    
     /**
     * @var RemoteWebDriver
     */
    //protected $webDriver;

     public function createApplication()
    {
        return require __DIR__ . "/../src/app.php";
    }
    
    

    protected function setUp() {
        $this->setBrowser('firefox');
        //$this->setPort(4444);
        //$this->setHost('http://jenkins.mastercase.net:4444/wd/hub');
        $this->setBrowserUrl('http://www1.mastercase.net/');
         //sleep(6);
        //teste
     }
    
  

    /**
     * @test
     */
    public function cadastrarUsuario() {
        
//        $session = $this->prepareSession();
////        // cookies
////        $session->cookie()->remove('language_version');
////        $session->cookie()->add('language_version', 'en')->set();
//        //$this->url('/');
//        //$session->cookie()->postCookie($data) ;
//        $session->url('/sandbox/gestor_inscricao/web/index.php');
//        //$session->by
        
        
        
        
        
        
        
        
          //sleep(9);
        $this->url("/sandbox/gestor_inscricao/web/index.php");
        $this->byXPath("//div[1]/div/div/div[3]/div/div/a")->click();
        $this->byId("nomecompleto")->value("Ana Clara Barvosa");
        $this->byId("email")->value("testetesteeee@teste5testeste.com.br");
        $this->byId("senha")->value("851703");
        $this->byId("resenha")->value("851703");
        $this->byId("datanascimento")->value("17/03/1985");
        $this->byId("select2-tipodocumento-container")->click();
        $this->byId("documento")->value("01417777");
        $this->byId("select2-tipocontato-container")->click();
        $this->byId("telefone")->value("017477777");
        $this->byXPath("//button[@type='button']")->click();
        $this->byId("select2-id_pais-container")->click();
        $this->byCssSelector("input.select2-search__field")->value("Brasil");
        $this->byCssSelector("#select2-id_pais-results li")->click();
        $this->byId("enderecoCep")->value("79106-087");
        $this->byId("enderecoLogradouro")->value("Carlos Arruda");
        $this->byId("enderecoEstado")->value("MS");
        $this->byId("enderecoCidade")->value("C.G");
        $this->byId("enderecoComplemento")->value("TSTE");
        $this->byId("select2-tipoendereco-container")->click();
        $this->byXPath("(//button[@type='button'])[4]")->click();
        $this->byId("select2-tipocliente-container")->click();
        $this->byCssSelector("input.select2-search__field")->value("Acadêmico");
        $this->byCssSelector('#select2-tipocliente-results li')->click();
        $this->byId("select2-id_universidade-container")->click();
        $this->byCssSelector("input.select2-search__field")->value("Outra");
        $this->byCssSelector('#select2-id_universidade-results li');
        $this->byId("select2-id_especializacao-container")->click();
        $this->byCssSelector("input.select2-search__field")->value("TÉCNICO");
        //ao selecionar 
        $this->byCssSelector('#select2-id_especializacao-results li');
        $this->byId("ano")->value("2014");
        $this->byXPath("(//button[@type='button'])[6]")->click();
        //$this->byLinkText("OK")->click();
    }
 /**
   * @test
   */
    public function efetuarLogin() {

        $this->url("/sandbox/gestor_inscricao/web/");
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byId("siteuser-email")->value("luciana@mastercase.com.br");
        $this->byId("siteuser-senha")->value("851703");
        $this->byId('siteuser-id_evento')->value('Testes do sistema Gestor de Eventos');
        $this->byXPath("//button[@type='submit']")->click();
        //usuario logou e fez logoff, clicou no botao sair 
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[4]");
    }

   /**
    * @test
    */
   public function recuperarSenhaEmailValido() {
        $this->url("/sandbox/gestor_inscricao/web/");
        $this->byXPath('//div[1]/div/div/div[2]/div/div/form/div[3]/a')->click();
        $this->byId("email")->click();
        $this->byId("email")->value("luciana@mastercase.com.br");
        $this->byXPath("//button[@type='submit']")->click();
        //clicou na mensagem de sucesso
        $this->byXPath("//div[1]/div/div/div[2]/div/div/div")->click();
    }
    
    /**
     * @test
     */
    public function editarPerfil() {
        $this->url("/sandbox/gestor_inscricao/web/");
        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
        $this->byId("siteuser-senha")->value("!12teste");
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byXPath("//button[@type='submit']")->click();
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[1]")->click();
        sleep(5);
        $this->byXPath("//div[2]/div/div[2]/ul/li[2]/a")->click();
        sleep(5);
        $this->byXPath("//div[2]/div[1]/div[3]/div/div[2]/div[2]/table/tbody/tr[2]/td[3]/button[1]")->click();
        sleep(5);
        $this->byXPath("//div[2]/div[2]/div/div/div[2]/form/div[3]/button")->click();
    }
}

