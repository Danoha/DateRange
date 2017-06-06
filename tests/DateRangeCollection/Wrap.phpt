<?php

require_once './../bootstrap.php';
use Tester\Assert;

$coll1 = \Danoha\DateRangeCollection::wrap([]);
Assert::same(\Danoha\DateRangeCollection::class, get_class($coll1));

$from = new \DateTime;
$coll2 = [
    [ 'from' => $from, 'to' => NULL, ],
];
Assert::same($coll2, (new \Danoha\DateRangeCollection($coll2))->unwrap());