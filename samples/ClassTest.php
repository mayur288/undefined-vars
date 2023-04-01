<?php

class Test {
    private $temp = 10;

    public function testFunctionOne($d) {
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
    
    public function testFunctionTwo() {
        $a = 10;
        $d = 40;
        if( $a < 10 ) {
            $b = 19;
            if( $b < 20 ) {
                $c = 30;
            }
        }
    
        $sum = $a - $b - $c - $d + $this->temp;
        echo 'Sum : ' . $sum;
    }
}

$t = new Test();
$t->testFunctionOne(40);
$t->testFunctionTwo();