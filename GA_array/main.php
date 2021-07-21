<?php

// using genetic algorithm MaxOne on array

$GOAL = [1,1,1,1,1,1,1,1,1,1];
$IND_NUMBER = 0;
$BORDER = 4;
$MUTATION_RATE = 2;
$FITTEST_QUOTE = 4;
$EVOLUTION_CYCLES = 100;
$CURRENT_POPULATION = [];
$ITERATIONS = 100;


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


function mutate_individual($individual){
    global $MUTATION_RATE;
    // choose how many mutation
    $mutation_quantity = rand(1, $MUTATION_RATE);

    // choose which genes will be mutating
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
            if($individual[$index]){
                $individual[$index] = 0;
            } else {
                $individual[$index] = 1;
            }
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
    global $EVOLUTION_CYCLES;
    $population = generate_population();
    $index = 1;
    while(!goal_achieved($population) && $index <= $EVOLUTION_CYCLES) {
        echo "STEP ".$index."\n";
        $population = evolution_step($population);
        print_population($population);
        $index++;
    }
    return $index;
}

function main(){
    global $ITERATIONS;
    $results = [];
    for($i=0; $i<$ITERATIONS; $i++){
        $results[] = evolution_cycle();
    }
    $average = array_sum($results)/count($results);
    echo json_encode($results)."\n";
    echo "Average number of steps to achieve goal fitness $average";
//    global $EVOLUTION_CYCLES;
//    $population = generate_population();
//    $index = 1;
//    while(!goal_achieved($population) && $index <= $EVOLUTION_CYCLES) {
//        echo "STEP ".$index."\n";
//        $population = evolution_step($population);
//        print_population($population);
//        $index++;
//    }
//
//    echo "End cycles\n";
//    echo "Goal achieved on $index steps\n";
//    echo "Final population:\n";
//    print_population($population);
}

main();
