<?php

$start = 11;
$end = 10;

if($start < $end )
    $sum = 0;
for ($i = $start; $i <= $end; $i++) {
    $sum += $i;
}

echo "Sum from " . $start . " to " . $end . " = " . $sum;