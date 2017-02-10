<?php

class TestExtra  extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        $this->setBrowser('chrome');
        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowserUrl('http://www.extra.com.br/');
    }
    
    /** 
     * Method test 
     * @test 
     */ 
    public function test()
    {
        $this->url("/");
        $this->byLinkText("Telefonia")->click();
        $this->byCssSelector("h3.tit.title2  > a")->click();
    }

}
