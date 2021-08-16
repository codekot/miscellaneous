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
        $this -> assertObjectHasAttribute("array", $i, "Individual has no array attribute");
        $this -> assertObjectHasAttribute("fitness", $i, "Individual has no fitness attribute");
        $this -> assertObjectHasAttribute("personal_number", $i, "Individual has no personal number");

        //attributes of proper types
        $this -> assertIsArray($i->array);
        $this -> assertIsFloat($i->fitness);
        $this -> assertIsInt($i->personal_number);

        //attribute values within proper range
        $this -> assertContainsOnly("int", $i->array);
        $this -> assertContains(0, $i->array);
        $this -> assertContains(1, $i->array);
        $this -> assertNotContains(3, $i->array);

        global $INDIVIDUAL_LENGTH;
        $this -> assertEquals($INDIVIDUAL_LENGTH, count($i->array));

        $this -> assertLessThanOrEqual(1.0, $i->fitness);
        $this -> assertGreaterThanOrEqual(0.0, $i->fitness);
    }
}
