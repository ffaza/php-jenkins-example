<?php

class TestExtra  extends PHPUnit_Extensions_Selenium2TestCase
{
    
    
     public function createApplication()
    {
        return require __DIR__ . "/../src/app.php";
    }
    
    
    /**
     * Setup
     */
    public function setUp()
    {
        $this->setBrowser('chrome');
        //$this->setHost('127.0.0.1');
        //$this->setPort(4444);
        $this->setBrowserUrl('http://www.extra.com.br/');
    }
    
   /**                                          
     * @test                                          
     */
    public function test()
    {
        $this->url("/");
        $this->byLinkText("Telefonia")->click();
        $this->byCssSelector("h3.tit.title2  > a")->click();
    }

}
