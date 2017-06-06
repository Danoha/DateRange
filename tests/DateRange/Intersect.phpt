<?php

require_once './../bootstrap.php';
use Tester\Assert;

$range1 = \Danoha\DateRange::wrap([NULL, NULL,]);
$range2 = \Danoha\DateRange::wrap([NULL, new \DateTime('2017-12-01'),]);
$range3 = \Danoha\DateRange::wrap([new \DateTime('2017-01-01'), NULL,]);
$range4 = \Danoha\DateRange::wrap([new \DateTime('2016-06-01'), new \DateTime('2017-05-31'),]);
$range5 = \Danoha\DateRange::wrap([new \DateTime('2017-06-01'), new \DateTime('2018-05-31'),]);

Assert::equal([
    'from' => NULL,
    'to' => new \DateTime('2017-12-01'),
], $range1->intersect($range2)->unwrap());

Assert::equal([
    'from' => new \DateTime('2017-01-01'),
    'to' => new \DateTime('2017-12-01'),
], $range2->intersect($range3)->unwrap());

Assert::equal([
    'from' => new \DateTime('2016-06-01'),
    'to' => new \DateTime('2017-05-31'),
], $range2->intersect($range4)->unwrap());

Assert::equal([
    'from' => new \DateTime('2017-01-01'),
    'to' => new \DateTime('2017-05-31'),
], $range3->intersect($range4)->unwrap());

Assert::equal([
    'from' => new \DateTime('2017-01-01'),
    'to' => new \DateTime('2017-05-31'),
], $range4->intersect($range3)->unwrap());

Assert::same([
    'from' => NULL,
    'to' => NULL,
], $range1->intersect($range1)->unwrap());

Assert::null($range4->intersect($range5));