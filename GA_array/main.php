<?php

// using genetic algorithm MaxOne on array

$INDIVIDUAL_LENGTH = 10;
$GOAL = array_map(function($i){return 1}, range(1, $INDIVIDUAL_LENGTH));
$IND_NUMBER = 1;
$BORDER = 4;
$MUTATION_RATE = 2;
$FITTEST_QUOTE = 4;
$EVOLUTION_CYCLES = 100;
$CURRENT_POPULATION = [];
$ITERATIONS = 1000;

class Individual {
    static private int $current_number = 1;

    public float $fitness;
    public int $personal_number;
    public array $array;

    public function __construct(){
        $this->array = self::generate_array();
        $this->fitness = self::fitness();
        $this->personal_number = self::get_number();
    }

    static private function generate_array(): array{
        $result = [];
        for($i=0; $i<10; $i++){
            $result[] = array_rand([0,1]);
        }
        return $result;
    }
    static private function fitness($individual): float{
        global $GOAL;
        //print_individual($individual);
        return array_sum($individual)/array_sum($GOAL);
     }

     static private function get_number(){
        $number = self::$current_number;
        self::$current_number ++;
        return $number;
     }


}

function fitness($individual): float{
    global $GOAL;
    //print_individual($individual);
    return array_sum($individual)/array_sum($GOAL);
}

function generate_individual(): array{
    $result = [];
    for($i=0; $i<10; $i++){
        $result[] = array_rand([0,1]);
    }
    return $result;
}

function individual_for_population(){
    global $IND_NUMBER;
    $arr = generate_individual();

}

function generate_population($population = [], $quantity = 10){
    global $IND_NUMBER;
    for($i=0; $i<$quantity; $i++){
        $population[] = [0.0, $IND_NUMBER, generate_individual()];
        $IND_NUMBER++;
    }
    return $population;
}

function choose_fittest($population){
    //print_population($population);
    foreach($population as &$individual) {
        $individual[0] = fitness($individual[2]);
        //echo $individual[0];
    }
    unset($individual);
    rsort($population);
    return $population;
}

function print_individual($individual){
    echo json_encode($individual)."\n";
}

function print_population($population){
    echo "POPULATION\n";
    foreach($population as $individual){
        print_individual($individual);
    }
    echo "\n";
}

function mutate_population($population){
    global $FITTEST_QUOTE;
    global $IND_NUMBER;
    // take first four of population and mutate it and fill the second half
    // fifth remain
    // last is random
    for ($i=0; $i<$FITTEST_QUOTE; $i++){
        $population[$i+5] = [0.0, $IND_NUMBER, mutate_individual($population[$i][2])];
        $IND_NUMBER++;
    }
    $population[9] = [0.0, $IND_NUMBER, generate_individual()];
    return $population;
}

function random_with_probability($p=80): bool {
    $ans = rand(1,100);
    if($ans<$p){
        return true;
    } else {
        return false;
    }
}

function one_point_crossover($parent1, $parent2, $cross_point=NULL){
    // find point of crossover
    if(!$cross_point){
        $cross_point = rand(1,9);
    }
    // swap tails
    $child1 = array_slice($parent1, 0,$cross_point);
    $child2 = array_slice($parent2, 0, $cross_point);
    $child1 = array_merge($child1, array_slice($parent2, $cross_point));
    $child2 = array_merge($child2, array_slice($parent1, $cross_point));
    return [$child1, $child2];
}

function contest($player1, $player2){
    if (fitness($player1)>fitness($player2)){
        return $player1;
    } else {
        return $player2;
    }
}
function tournament_crossing($population, $rounds=2){
    $childrens = [];
    for($i=0; $i<$rounds; $i++){
        $parent1 = contest(rand($population)[2], rand($population)[2]);
        $parent2 = contest(rand($population)[2], rand($population)[2]);
        $childrens = array_merge($childrens, one_point_crossover($parent1, $parent2));
    }
    $population = array_merge(
        array_slice($population, 0, -($rounds*2)+1),
        $childrens);
    $population[-1] = generate_individual();
    return $population;
}

function population_crossing($population){
    $result = [];
    $rounds = 2;
    for($i=0; $i<$rounds; $i++){

    }

}

function mutate_individual($individual){
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
            $individual[$index] = $individual[$index] ? 0 : 1;
//            if($individual[$index]){
//                $individual[$index] = 0;
//            } else {
//                $individual[$index] = 1;
//            }
        }
    }
    return $individual;
}

function evolution_step($population){
    global $CURRENT_POPULATION;
    $population = choose_fittest($population);
    // should break out of the cycle immediately as fittest individual occur
    if(goal_achieved($population)){
        echo "BREAK\n";
        return $population;
    }
    $population = mutate_population($population);
    $CURRENT_POPULATION = $population;
    return $population;
}

function goal_achieved($population): bool{
    if ($population[0][0] >= 1.0){
        return true;
    }  else {
        return false;
    }
}

function evolution_cycle(){
    global $IND_NUMBER;
    global $EVOLUTION_CYCLES;
    $IND_NUMBER = 1;
    $population = generate_population();
    $index = 0;
    while(!goal_achieved($population) && $index < $EVOLUTION_CYCLES) {
        echo "STEP ".$index."\n";
        $population = evolution_step($population);
        // print_population($population);
        $index++;
    }
    return $index;
}

function test_one_point_crossover(){
    $p1 = [1,1,1,0,0,0,0,0,0,0];
    $p2 = [0,0,0,1,1,1,1,1,1,1];
    $test = one_point_crossover($p1, $p2, 3);
    echo json_encode($test[0]);
    echo json_encode($test[1]);

}
function main(){
    global $ITERATIONS;
    $results = [];
    for($i=0; $i<$ITERATIONS; $i++){
        $results[] = evolution_cycle();
    }
    $average = array_sum($results)/count($results);
    $max = max($results);
    $min = min($results);
    echo json_encode($results)."\n";
    echo "Average number of steps to achieve goal fitness $average\n";
    echo "Minimum number of steps to achieve goal fitness $min\n";
    echo "Maximum number of steps to achive goal fitness $max\n";
}


test_one_point_crossover();
main();
