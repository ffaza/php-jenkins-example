<?php
//$path = '../../../../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/Selenium2TestCase.php';
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
        //$this->setPort(4444);
        $this->setBrowserUrl('http://www1.mastercase.net/');
        //$this->setHost('http://jenkins.mastercase.net:4444/wd/hub');
        $this->setBrowserUrl('http://www1.mastercase.net/');

   
} 

 
  
    /**                                          
     * @test                                          
     */                                                       
    public function pagamentoBoleto() {
        $this->url("/sandbox/gestor_inscricao/web/");
        
          
        //setar cookies
        $this->cookie()->remove('language_version');
        $this->cookie()->add('language_version', 'en')->set();
                  
        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
        $this->byId("siteuser-senha")->value("!12teste");
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byXPath("//button[@type='submit']")->click();
        $this->byCssSelector("button.btn.btn-primary")->click();
        $this->byId("TABELA_BOLETO")->click();
        $this->byId("gerar_boleto")->click();
        sleep(5);
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[4]")->click();    
    }
     
    /**                                          
     * @test                                          
     */                                                       
    public function pagamentoBoletoDesconto() {
        //testes
        $this->url("/sandbox/gestor_inscricao/web/");
        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
        $this->byId("siteuser-senha")->value("!12teste");
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byXPath("//button[@type='submit']")->click();
        $this->byCssSelector("button.btn.btn-primary")->click();
        $this->byName("cupom")->value("DESCONTO1000");
        $this->byCssSelector("button.btn.btn-default")->click();
        $this->byId("TABELA_BOLETO")->click();
        $this->byId("gerar_boleto")->click();
        sleep(5);
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[4]")->click();
    }
    
    /**
     * @test
     */
    public function consultarMinhasComprar() {
        $this->url("/sandbox/gestor_inscricao/web/");
        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
        $this->byId("siteuser-senha")->value("!12teste");
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byXPath("//button[@type='submit']")->click();
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[2]")->click();
        $this->byXPath("//div[2]/div[1]/div[2]/ul/li[2]/a")->click();
    }
    
    /**
     * @test
     */
    public function alterarEndereco() {
        $this->url("/sandbox/gestor_inscricao/web/");
        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
        $this->byId("siteuser-senha")->value("!12teste");
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byXPath("//button[@type='submit']")->click();
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[2]")->click();
        $this->byXPath("//div[2]/div[1]/div[2]/ul/li[2]/a")->click();
        $this->byXPath("(//a[contains(text(),'Pagar agora')])[31]")->click();
        $this->byCssSelector("button.btn.btn-primary")->click();
        sleep(5);
        $this->byName("enderecoEntregue")->click();
        sleep(5);
        $this->byXPath("//div[2]/div[3]/div/div/div[3]/div/form/div/div[1]/div[1]/div/input")->value("79031-007");
        $this->byCssSelector("div.col-xs-12.clearfix > div.pull-right > button.btn.btn-primary")->click();
        $this->byCssSelector("button.swal2-confirm.styled")->click();
        sleep(5);
        $this->byCssSelector("div.col-xs-12.clearfix > div.pull-right > button.btn.btn-primary")->click();
        sleep(5);
        $this->byCssSelector("button.swal2-confirm.styled")->click();
    }
    
    /**
     * @test
     */
    public function alterarRepresentate() {
        $this->url("/sandbox/gestor_inscricao/web/");
        $this->byId("siteuser-email")->value("ricardo@mastercase.com.br");
        $this->byId("siteuser-senha")->value("!12teste");
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select")->click();
        $this->byXPath("//div[1]/div/div/div[2]/div/div/form/select/option[4]")->click();
        // ERROR: Caught exception [TypeError: value.replace is not a function]
        $this->byXPath("//button[@type='submit']")->click();
        $this->byXPath("//div[1]/div/div/div/div/div[2]/a[2]")->click();
        $this->byXPath("//div[2]/div[1]/div[2]/ul/li[2]/a")->click();
        $this->byXPath("(//a[contains(text(),'Pagar agora')])[18]")->click();
        sleep(5);
        $this->byXPath("(//button[@type='button'])[3]")->click();
        sleep(5);
        $this->byXPath("//div[2]/div[4]/div/div/div[3]/div/form/div/div[1]/div/span/span[1]/span/span[2]/b")->click();
        $this->byXPath("//span/span/span[2]/ul/li[4]")->click();
        $this->byXPath("//div[2]/div[4]/div/div/div[3]/div/form/div/div[2]/div/button[2]")->click();
    }
} 