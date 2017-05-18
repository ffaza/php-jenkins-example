<?php
$path = '../../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase.php';
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
 * Description of ManterPagamentoteste
 *
 * @author Ricardo Koester
 */
class ManterPagamentoteste  extends PHPUnit_Extensions_Selenium2TestCase {
    
     
      public function createApplication()
    {
        return require __DIR__ . "/../src/app.php";
    }
    
           
    //put your code here
      protected function setUp() {
         // System.
          
        $this->setBrowser('chrome');
        //$this->setHost('10.41.1.131');
        //$this->setPort(8896);
        $this->setBrowserUrl('http://10.41.1.20/');
        //$this->setBrowserUrl('http://www.google.com.br/');
        //$this->setupSpecificBrowser($params);
        //$this->runTest()
       } 
   
    /**                                          
     * @test                                          
     */                                                       
    public function pagamentoBoleto() {
        
        //$this->w
        
//            //$teste = array();
   //$session = $this->prepareSession();
//        $session->url('/sandbox/gestor_inscricao/web/');
//        //$session->
//        //$session->cookie()->;
//         //$session->$cookies->add($this->byId("siteuser-email"), "ricardo@mastercase.com.br");
       //$session->cookie()->add('', $value);
//         $session->byId("siteuser-email")->value("ricardo@mastercase.com.br");
//         $session->cookie()->add($name, $value)->path($path);
         //$session->cookie()->add($name, $value)->
        // cookies
        //$session->cookie()->remove('language_version');
        //$session->cookie()->add('language_version', 'en')->set();
        //$this->url('/');
        //$session->cookie()->add($data) ;
        //$session->url('/sandbox/gestor_inscricao/web/');
        
        //$this->url('http://www.google.com.br/');
        $this->url("/sandbox/gestor_inscricao/web/");
        
//        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
//        $this->byId("siteuser-senha")->value("!12teste");
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
//        // ERROR: Caught exception [TypeError: value.replace is not a function]
//        $this->byXPath("//button[@type='submit']")->click();
//        $this->byCssSelector("button.btn.btn-primary")->click();
//        $this->byId("TABELA_BOLETO")->click();
//        $this->byId("gerar_boleto")->click();
//        sleep(5);
//        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[4]")->click(); 
        //$this->p
    }
    
    
      public function prepareSession()
    {
        $session = parent::prepareSession();
        $this->url('/sandbox/gestor_inscricao/web/');

        return $session;
    }
     
    /**                                          
     * @test                                          
     */                                                       
    public function pagamentoBoletoDesconto() {
        //testes
        //$arrayFofinhoFunciona = array();
        //$session = $this->prepareSession();
        //$session->url('/sandbox/gestor_inscricao/web/');
        
       //$arrayFofinhoFunciona[]=$this->url("/sandbox/gestor_inscricao/web/");
//        $arrayFofinhoFunciona[]= $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
//        $arrayFofinhoFunciona[]=$this->byId("siteuser-senha")->value("!12teste");
//        $arrayFofinhoFunciona[]=$this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
//        $arrayFofinhoFunciona[]=$this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
//        // ERROR: Caught exception [TypeError: value.replace is not a function]
//        $arrayFofinhoFunciona[]= $this->byXPath("//button[@type='submit']")->click();
//        $arrayFofinhoFunciona[]=$this->byCssSelector("button.btn.btn-primary")->click();
//        $arrayFofinhoFunciona[]= $this->byName("cupom")->value("DESCONTO1000");
//        $arrayFofinhoFunciona[]=$this->byCssSelector("button.btn.btn-default")->click();
//        $arrayFofinhoFunciona[]=$this->byId("TABELA_BOLETO")->click();
//        $arrayFofinhoFunciona[]=$this->byId("gerar_boleto")->click();
//        //$arrayFofinhoFunciona[]=sleep(5);
//        $arrayFofinhoFunciona[]=$this->byXPath("//div[1]/div/div/div/div/div[2]/a[4]")->click();
        //$session->cookie()->postCookie($arrayFofinhoFunciona);
    }
    
    
   
    
    
//    
//    /**
//     * @test
//     */
//    public function consultarMinhasComprar() {
//        $this->url("/sandbox/gestor_inscricao/web/");
//        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
//        $this->byId("siteuser-senha")->value("!12teste");
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
//        // ERROR: Caught exception [TypeError: value.replace is not a function]
//        $this->byXPath("//button[@type='submit']")->click();
//        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[2]")->click();
//        $this->byXPath("//div[2]/div[1]/div[2]/ul/li[2]/a")->click();
//    }
//    
//    /**
//     * @test
//     */
//    public function alterarEndereco() {
//        $this->url("/sandbox/gestor_inscricao/web/");
//        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
//        $this->byId("siteuser-senha")->value("!12teste");
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
//        // ERROR: Caught exception [TypeError: value.replace is not a function]
//        $this->byXPath("//button[@type='submit']")->click();
//        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[2]")->click();
//        $this->byXPath("//div[2]/div[1]/div[2]/ul/li[2]/a")->click();
//        $this->byXPath("(//a[contains(text(),'Pagar agora')])[31]")->click();
//        $this->byCssSelector("button.btn.btn-primary")->click();
//        sleep(5);
//        $this->byName("enderecoEntregue")->click();
//        sleep(5);
//        $this->byXPath("//div[2]/div[3]/div/div/div[3]/div/form/div/div[1]/div[1]/div/input")->value("79031-007");
//        $this->byCssSelector("div.col-xs-12.clearfix > div.pull-right > button.btn.btn-primary")->click();
//        $this->byCssSelector("button.swal2-confirm.styled")->click();
//        sleep(5);
//        $this->byCssSelector("div.col-xs-12.clearfix > div.pull-right > button.btn.btn-primary")->click();
//        sleep(5);
//        $this->byCssSelector("button.swal2-confirm.styled")->click();
//    }
//    
//    /**
//     * @test
//     */
//    public function alterarRepresentate() {
//        $this->url("/sandbox/gestor_inscricao/web/");
//        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
//        $this->byId("siteuser-senha")->value("!12teste");
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
//        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
//        // ERROR: Caught exception [TypeError: value.replace is not a function]
//        $this->byXPath("//button[@type='submit']")->click();
//        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[2]")->click();
//        $this->byXPath("//div[2]/div[1]/div[2]/ul/li[2]/a")->click();
//        $this->byXPath("(//a[contains(text(),'Pagar agora')])[18]")->click();
//        sleep(5);
//        $this->byXPath("(//button[@type='button'])[3]")->click();
//        sleep(5);
//        $this->byXPath("//div[2]/div[4]/div/div/div[3]/div/form/div/div[1]/div/span/span[1]/span/span[2]/b")->click();
//        $this->byXPath("//span/span/span[2]/ul/li[4]")->click();
//        $this->byXPath("//div[2]/div[4]/div/div/div[3]/div/form/div/div[2]/div/button[2]")->click();
//    }
} 