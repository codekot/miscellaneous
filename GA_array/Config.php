<?php

$INDIVIDUAL_LENGTH = 10;
$GOAL = array_map(function (){return 1;}, range(1, $INDIVIDUAL_LENGTH));
$IND_NUMBER = 1;
$BORDER = 4;
$MUTATION_RATE = 1;
$FITTEST_QUOTE = 4;
$EVOLUTION_CYCLES = 100;
$CURRENT_POPULATION = [];
$ITERATIONS = 1000;

class Config{
    public $INDIVIDUAL_LENGTH = 10;
    public $GOAL = [];
    public $IND_NUMBER = 1;
    public $BORDER = 4;
    public $MUTATION_RATE = 1;
    public $FITTEST_QUOTE = 4;
    public $EVOLUTION_CYCLES = 100;
    public $CURRENT_POPULATION = [];
    public $ITERATIONS = 1000;

    public function __construct(){
        $this->GOAL = $this->setGoal();
    }

    public function setValue($var, $value){
        $this -> $var = $value;
        if($var="INDIVIDUAL_LENGTH"){
            $this->GOAL = setGoal();
        }
    }

    public function setGoal(){
        return array_map(function (){return 1;}, range(1, $this->INDIVIDUAL_LENGTH));
    }
}
