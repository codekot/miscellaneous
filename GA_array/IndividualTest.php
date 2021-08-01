<?php

require_once "Config.php";
require_once "Individual.php";

class IndividualTest extends \PHPUnit\Framework\TestCase {

    public function testNewIndividual(){
        $i = new Individual();
        $this -> assertInstanceOf(
            Individual::class,
            $i
        );


    }
}
