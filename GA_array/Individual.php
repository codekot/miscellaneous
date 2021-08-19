<?php

class Individual {
    static private int $current_number = 1;

    public float $fitness;
    public int $personal_number;
    public array $array;

    public function __construct(){
        $this->array = self::generate_array();
        $this->fitness = self::get_fitness();
        $this->personal_number = self::get_number();
    }

    static private function generate_array(): array{
        global $INDIVIDUAL_LENGTH;
        $result = [];
        for($i=0; $i<$INDIVIDUAL_LENGTH; $i++){
            $result[] = array_rand([0,1]);
        }
        return $result;
    }

    public function get_fitness(): float{
        global $GOAL;
        $f = array_sum($this->array)/array_sum($GOAL);
        $this->fitness = $f;
        return $f;
    }

    static public function get_number(): int
    {
        $number = self::$current_number;
        self::$current_number ++;
        return $number;
    }

    public function __toString(){
        return "Individual #$this->personal_number, fitness: $this->fitness ".json_encode($this->array)."\n";
    }

    public function clone_individual(): Individual
    {
        $clone = clone $this;
        $clone->personal_number = self::get_number();
        return $clone;
    }

    public function mutate_individual(): Individual
    {
        global $MUTATION_RATE;
        global $INDIVIDUAL_LENGTH;
        // choose how many mutation
        $mutation_quantity = rand(1, $MUTATION_RATE);

        // choose which genes will be mutated
        $index_array = [];
        for($i=0; $i<$mutation_quantity; $i++){
            $index_value = rand(0, $INDIVIDUAL_LENGTH-1);
            if(!array_search($index_value, $index_array)) {
                $index_array[] = $index_value;
            }
        }

        // mutate selected genes with some probability
        $clone = $this->clone_individual();
        foreach($index_array as $index){
            if(random_with_probability()){
                $clone->array[$index] = $clone->array[$index] ? 0 : 1;
            }
        }
        $clone->get_fitness();
        return $clone;
    }
}
