<?php

$temp = 10;

function testFunctionOne($d) {
    $a = 10;
    if( $a < 10 ) {
        $b = 20;
        if( $b < 20 ) {
            $c = 30;
        }
    }

    $sum = $a + $b + $c + $d;
    echo 'Sum : ' . $sum;
}

function testFunctionTwo() {
    $a = 10;
    $d = 40;
    if( $a < 10 ) {
        $b = 19;
        if( $b < 20 ) {
            $c = 30;
        }
    }

    $sum = $a - $b - $c - $d + $temp;
    echo 'Sum : ' . $sum;
}

testFunctionOne(40);
testFunctionTwo();