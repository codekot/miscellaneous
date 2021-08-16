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
        //object has proper attributes
        $this -> assertObjectHasAttribute("array", $i);
        $this -> assertObjectHasAttribute("fitness", $i);
        $this -> assertObjectHasAttribute("personal_number", $i);

        //attributes of proper types
        $this -> assertIsArray($i->array);
        $this -> assertIsFloat($i->fitness);
        $this -> assertIsInt($i->personal_number);


    }
}
