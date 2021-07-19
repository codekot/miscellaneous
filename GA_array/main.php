<?php

// using genetic algorithm on array

$GOAL = array([1,1,1,1,1,1,1,1,1,1]);

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

function generate_population($quantity = 10){
    $population = [];
    for($i=0; $i<$quantity; $i++){
        $population[] = generate_individual();
    }
    return $population;
}

//function chose_fittest($population){
//    for (count($population));
//}