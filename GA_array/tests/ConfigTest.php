<?php

require_once "Config.php";

class ConfigTest extends \PHPUnit\Framework\TestCase {

    function testNewConfig(){
        $c = new Config();
        $this -> assertInstanceOf(Config::class, $c);
    }
}