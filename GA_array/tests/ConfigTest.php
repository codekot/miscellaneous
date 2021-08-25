<?php

require_once "Config.php";

class ConfigTest extends \PHPUnit\Framework\TestCase {

    function testNewConfig(){
        $c = Config::getInstance();
        $this -> assertInstanceOf(Config::class, $c);

        $c2 = Config::getInstance();
        $this -> assertSame($c, $c2);

        $this -> expectExceptionMessage("Call to protected Config::__construct() from scope ConfigTest");
        $c3 = new Config();
    }

    function testSetInvalidProperty(){
        $c = Config::getInstance();;
        $this -> expectExceptionMessage("invalid property name");
        $c->testing_property = 42;
    }

    function testSetGoal(){
        $c = Config::getInstance();
        $this -> expectExceptionMessage("access denied, to change GOAL, change INDIVIDUAL_LENGTH");
        $c->GOAL = [];
    }

    function testSetIndividualLength(){
        $c = Config::getInstance();
        $c2 = Config::getInstance();
        $c->INDIVIDUAL_LENGTH = 12;
        $this -> assertEquals(12, $c->INDIVIDUAL_LENGTH);
        $this -> assertEquals(12, count($c->GOAL));

        $this -> assertEquals($c->GOAL, $c2->GOAL);
    }




}