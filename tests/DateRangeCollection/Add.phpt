<?php

require_once './../bootstrap.php';
use Tester\Assert;

$from = new \DateTime;
$coll = new \Danoha\DateRangeCollection([
    [$from, NULL,],
]);

$to = new \DateTime;
$coll2 = $coll->add([
    [NULL, $to,],
]);

Assert::notSame($coll, $coll2);

Assert::same([
    ['from' => $from, 'to' => NULL,],
], $coll->unwrap());

Assert::same([
    ['from' => $from, 'to' => NULL,],
    ['from' => NULL, 'to' => $to,],
], $coll2->unwrap());