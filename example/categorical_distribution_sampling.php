<?php

use Sumtree\Sumtree;

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Assume we must draw a vowel according to this probability distribution:
 *
 *  A=0.3, E=0.3, U=0.1, I=0.15, O=0.1, Y=0.05
 *
 */

$sumtree = new Sumtree(6);
$sumtree->add('a', 0.3);
$sumtree->add('e', 0.3);
$sumtree->add('u', 0.1);
$sumtree->add('i', 0.15);
$sumtree->add('o', 0.1);
$sumtree->add('y', 0.05);

$precision = 1000.0;
$count = 10000;

$samples = [
    'a' => 0,
    'e' => 0,
    'u' => 0,
    'i' => 0,
    'o' => 0,
    'y' => 0,
];

echo "Drawing $count samples according to the following distribution : " . PHP_EOL;
echo "A=0.3, E=0.3, U=0.1, I=0.15, O=0.1, Y=0.05" . PHP_EOL. PHP_EOL;

while ($count--) {
    // we pick a uniformly distributed number
    $random = (float)rand(0, $precision) / $precision;
    // and use the sumtree to perform a binary search on the cumulative distribution
    $samples[$sumtree->getElement($random)]++;
}

var_dump($samples);
