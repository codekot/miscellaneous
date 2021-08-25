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
    private  $INDIVIDUAL_LENGTH = 10;
    private  $GOAL = [];
    public $IND_NUMBER = 1;
    public $POPULATION_SIZE = 10;
    public $BORDER = 4;
    public $MUTATION_RATE = 1;
    public $FITTEST_QUOTE = 4;
    public $EVOLUTION_CYCLES = 100;
    public $CURRENT_POPULATION = [];
    public $ITERATIONS = 1000;

    private static $instance = null;

    public static function getInstance(): Config
    {
        if(static::$instance === null){
            static::$instance = new static();
            static::$instance->GOAL = static::$instance->setGoal();
        }
        return static::$instance;
    }

    protected function __construct(){
    }

    protected function __clone(){
    }

    public function setGoal(){
        return array_map(function (){return 1;}, range(1, $this->INDIVIDUAL_LENGTH));
    }

    public function __set($name, $value){
        if(!property_exists($this, $name)){
            throw new Exception("invalid property name");
        } elseif ($name == "INDIVIDUAL_LENGTH"){
            $this->INDIVIDUAL_LENGTH = $value;
            $this->GOAL = $this->setGoal();
        } elseif ($name == "GOAL"){
            throw new Exception("access denied, to change GOAL, change INDIVIDUAL_LENGTH");
        }
    }

    public function __get($name){
        if($name == "INDIVIDUAL_LENGTH"){
            return $this->INDIVIDUAL_LENGTH;
        } elseif ($name == "GOAL"){
            return $this->GOAL;
        } else {
            throw new Exception("invalid property name");
        }
    }
}

$c = Config::getInstance();
$c->INDIVIDUAL_LENGTH = 15;
