<?php

// using genetic algorithm on array

$GOAL = [1,1,1,1,1,1,1,1,1,1];
$IND_NUMBER = 0;
$BORDER = 4;
$MUTATION_RATE = 2;
$FITTEST_QUOTE = 4;
$EVOLUTION_CICLES = 1000;
$CURRENT_POPULATION = [];


function fitness($individual){
    global $GOAL;
    return array_sum($individual)/array_sum($GOAL);
}

function generate_individual(){
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
    echo "hello";
    foreach($population as $number => &$individual) {
        $individual[0] = fitness($individual[2]);
        echo $individual[0];
    }
    unset($individual);
    arsort($population);
    return $population;
}

function cut_weakest($population){
    global $BORDER;
    for($i=0; $i<$BORDER; $i++){
        array_pop($population);
    }
}

function mutate_population($population){
    global $FITTEST_QUOTE;
    global $IND_NUMBER;
    // take first four of population and mutate it and fill the second half
    // fifth remain
    // last is random
    $i = 0;
    for ($i=0; $i<$FITTEST_QUOTE; $i++){
        $population[$i+5] = [0.0, $IND_NUMBER, mutate_individual($population[$i][3])];
        $IND_NUMBER++;
    }
    $population[9] = [0.0, $IND_NUMBER, generate_individual()];
}

function random_with_probability($p=80){
    $ans = rand(range(1,100));
    if($ans<$p){
        return true;
    } else {
        return false;
    }
}


function mutate_individual($individual){
    global $MUTATION_RATE;
    // choose how many mutation
    $mutation_quantity = rand(range(1, $MUTATION_RATE));

    // choose which genes will be mutating
    $index_array = [];
    for($i=0; $i<$mutation_quantity; $i++){
        $index_value = rand(range(0, 9));
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
    $f = choose_fittest($population);
    // $f = fitness([0,1,0,1,0,1,0,1,0,0]);
    //echo var_dump($f);
    echo var_dump($f[0]);
}

function main(){
    global $EVOLUTION_CICLES;
    global $CURRENT_POPULATION;
    $population = generate_population();
    for($i=0; $i<$EVOLUTION_CICLES; $i++){
        $result = evolution_step();
        if($result){
            echo $result;
        }
    }
    echo "End cicles";
    echo "Final population:";
    echo var_dump($CURRENT_POPULATION);
}

main();
