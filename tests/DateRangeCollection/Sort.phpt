<?php

require_once './../bootstrap.php';
use Tester\Assert;

$date1 = new \DateTime('2017-01-01');
$date2 = new \DateTime('2017-06-01');
$date3 = new \DateTime('2017-06-30');
$date4 = new \DateTime('2017-12-31');

Assert::same([
    ['from' => NULL, 'to' => $date1,],
    ['from' => NULL, 'to' => $date2,],
    ['from' => NULL, 'to' => $date3,],
    ['from' => NULL, 'to' => $date4,],
    ['from' => NULL, 'to' => NULL,],
    ['from' => $date1, 'to' => $date4,],
    ['from' => $date1, 'to' => NULL,],
    ['from' => $date2, 'to' => $date3,],
    ['from' => $date2, 'to' => NULL,],
    ['from' => $date3, 'to' => $date1,],
    ['from' => $date3, 'to' => NULL,],
    ['from' => $date4, 'to' => $date2,],
    ['from' => $date4, 'to' => NULL,],
], (new \Danoha\DateRangeCollection([
    ['from' => $date3, 'to' => NULL,],
    ['from' => $date2, 'to' => NULL,],
    ['from' => $date2, 'to' => $date3,],
    ['from' => NULL, 'to' => $date3,],
    ['from' => $date4, 'to' => NULL,],
    ['from' => NULL, 'to' => NULL,],
    ['from' => NULL, 'to' => $date1,],
    ['from' => NULL, 'to' => $date2,],
    ['from' => $date1, 'to' => NULL,],
    ['from' => $date1, 'to' => $date4,],
    ['from' => $date4, 'to' => $date2,],
    ['from' => NULL, 'to' => $date4,],
    ['from' => $date3, 'to' => $date1,],
]))->unwrap());