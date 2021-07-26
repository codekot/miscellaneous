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
        $result = [];
        for($i=0; $i<10; $i++){
            $result[] = array_rand([0,1]);
        }
        return $result;
    }

    private function get_fitness(): float{
        global $GOAL;
        return array_sum($this->array)/array_sum($GOAL);
    }

    static public function get_number(){
        $number = self::$current_number;
        self::$current_number ++;
        return $number;
    }

    public function __toString(){
        return "Individual #$this->personal_number, fitness: $this->fitness ".json_encode($this->array)."\n";
    }

    public function mutate_individual(){
        global $MUTATION_RATE;
        // choose how many mutation
        $mutation_quantity = rand(1, $MUTATION_RATE);

        // choose which genes will be mutated
        $index_array = [];
        for($i=0; $i<$mutation_quantity; $i++){
            $index_value = rand(0, 9);
            if(!array_search($index_value, $index_array)) {
                $index_array[] = $index_value;
            }
        }

        // mutate selected genes with some probability
        foreach($index_array as $index){
            if(random_with_probability()){
                $this->array[$index] = $this->array[$index] ? 0 : 1;
            }
        }
        $this->get_fitness();
    }
}
