<?php
require('../vendor/autoload.php');

use Protobellum\Army;

$me     = new Army('Ravens of Mayhem', rand(1000, 10000));
$foe    = new Army('Lumbering Sloths', rand(1000, 10000));

$me->muster();
$foe->muster();

while (! $me->surrendered && ! $foe->surrendered) {
    echo '<hr/>';

    if (rand(0, 1) == 0) {
        echo "<i>The $me->name have attacked!</i><br/>";
        $me->attack($foe);
    } else {
        echo "<i>The $foe->name have attacked!</i><br/>";
        $foe->attack($me);
    }

    $me->muster();
    $foe->muster();
}

