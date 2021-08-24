<?php

require_once "Config.php";
require_once "Population.php";


class PopulationTest extends \PHPUnit\Framework\TestCase
{
    function testNewPopulation(){
        $p = new Population();
        $this -> assertInstanceOf(
            Population::class,
            $p
        );
        $this -> assertObjectHasAttribute("set", $p);
        $this -> assertObjectHasAttribute("goal_achieved", $p);
        $this -> assertIsArray($p->set);
        $this -> assertIsBool($p->goal_achieved);
    }

}