<?php

// using genetic algorithm MaxOne on array

$INDIVIDUAL_LENGTH = 10;
$GOAL = array_map(function (){return 1;}, range(1, $INDIVIDUAL_LENGTH));
$IND_NUMBER = 1;
$BORDER = 4;
$MUTATION_RATE = 1;
$FITTEST_QUOTE = 4;
$EVOLUTION_CYCLES = 100;
$CURRENT_POPULATION = [];
$ITERATIONS = 1000;

require_once  "Individual.php";

require_once "Population.php";

function random_with_probability($p=80): bool {
    $ans = rand(1,100);
    if($ans<$p){
        return true;
    } else {
        return false;
    }
}




function smutate_population($population){
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





function goal_achieved($population): bool{
    if ($population[0][0] >= 1.0){
        return true;
    }  else {
        return false;
    }
}

function evolution_step($population){
    global $CURRENT_POPULATION;
    $population->choose_fittest();
    // should break out of the cycle immediately as fittest individual occur
    if($population->is_goal_achieved()){
        echo "BREAK\n";
        return $population;
    }
    $population->mutate_population();
    $CURRENT_POPULATION = $population;
    return $population;
}

function evolution_cycle(){
    global $IND_NUMBER;
    global $EVOLUTION_CYCLES;
    $IND_NUMBER = 1;
    $population = new Population();
    $index = 0;
    while(!$population->is_goal_achieved() && $index < $EVOLUTION_CYCLES) {
        echo "STEP ".$index."\n";
        $population = evolution_step($population);
        echo $population->get_best_fittest_score();
        //echo $population;
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

function test_individual_get_fitness(){
    global $GOAL;
    $i = new Individual();
    $i->array = [0,0,0,0,0,0,0,0,0,1];
    echo $i->get_fitness();
    echo $i->fitness;
    echo json_encode($GOAL);

}

function test_individual_to_string(){
    $i = new Individual();
    echo $i;
}

function test_population(){
    echo "TEST POPULATION\n";
    $p = new Population();
    echo $p;
}

function test_mutate_individual(){
    $i1 = new Individual();
    echo $i1;
    $i2 = $i1->mutate_individual();
    if($i2){
        echo $i2;
    } else {
        echo "No muteted clone";
    }

}

function test_mutate_population(){
    $p = new Population();
    echo $p;
    $p->mutate_population();
    echo $p;
}

function test_evolution_step(){
    $p = new Population();
    echo $p;
    $p = evolution_step($p);
    echo $p;
}

function test_evolution_cycle(){
    evolution_cycle();
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


//test_individual_to_string();
//test_population();
//test_mutate_individual();
//test_mutate_population();
//test_evolution_step();
//test_evolution_cycle();
//test_individual_get_fitness();
main();