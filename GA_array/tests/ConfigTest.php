<?php

require_once "Config.php";

class ConfigTest extends \PHPUnit\Framework\TestCase {

    function testNewConfig(){
        $c = new Config();
        $this -> assertInstanceOf(Config::class, $c);
    }

    function testSetInvalidProperty(){
        $c = new Config();
        $this -> expectExceptionMessage("invalid property name");
        $c->testing_property = 42;
    }

    function testSetGoal(){
        $c = new Config();
        $this -> expectExceptionMessage("access denied, to change GOAL, change INDIVIDUAL_LENGTH");
        $c->GOAL = [];
    }

    function testSetIndividualLength(){
        $c = new Config();
        $c->INDIVIDUAL_LENGTH = 12;
        $this -> assertEquals(12, $c->INDIVIDUAL_LENGTH);
        $this -> assertEquals(12, count($c->GOAL));
    }




}