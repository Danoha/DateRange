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

$coll3 = new \Danoha\DateRangeCollection([]);
Assert::same($coll3, \Danoha\DateRangeCollection::wrap($coll3));

$range1 = new \Danoha\DateRange();
$range2 = new \Danoha\DateRange();
Assert::same([$range1, $range2], (new \Danoha\DateRangeCollection([$range1, $range2]))->getRanges());