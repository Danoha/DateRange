<?php

require_once './../bootstrap.php';
use Tester\Assert;

$range1 = \Danoha\DateRange::wrap([NULL, NULL,]);
$range2 = \Danoha\DateRange::wrap([NULL, new \DateTime('2017-12-01'),]);
$range3 = \Danoha\DateRange::wrap([new \DateTime('2017-01-01'), NULL,]);
$range4 = \Danoha\DateRange::wrap([new \DateTime('2016-06-01'), new \DateTime('2017-05-31'),]);
$range5 = \Danoha\DateRange::wrap([new \DateTime('2017-06-01'), new \DateTime('2018-05-31'),]);

Assert::equal([
    ['from' => NULL, 'to' => new \DateTime('2017-05-31'),],
    ['from' => new \DateTime('2018-06-01'), 'to' => NULL,],
], (new \Danoha\DateRangeCollection([$range1]))->subtract([
    $range5,
])->unwrap());

Assert::equal([], (new \Danoha\DateRangeCollection([$range2]))->subtract([
    $range2,
])->unwrap());

Assert::equal([], (new \Danoha\DateRangeCollection([$range4, $range3]))->subtract([
    $range1,
])->unwrap());

Assert::equal([
    ['from' => new \DateTime('2017-06-01'), 'to' => NULL,],
], (new \Danoha\DateRangeCollection([$range4, $range3]))->subtract([
    $range4,
])->unwrap());

Assert::equal([
    $range5->unwrap(),
], (new \Danoha\DateRangeCollection([$range4, $range5]))->subtract([
    $range4,
])->unwrap());

Assert::equal([
    $range4->unwrap(),
], (new \Danoha\DateRangeCollection([$range4, $range5]))->subtract([
    $range5,
])->unwrap());