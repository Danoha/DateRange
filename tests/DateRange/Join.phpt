<?php

require_once './../bootstrap.php';
use Tester\Assert;

$range1 = \Danoha\DateRange::wrap([NULL, NULL,]);
$range2 = \Danoha\DateRange::wrap([NULL, new \DateTime('2017-12-01'),]);
$range3 = \Danoha\DateRange::wrap([new \DateTime('2017-01-01'), NULL,]);
$range4 = \Danoha\DateRange::wrap([new \DateTime('2016-06-01'), new \DateTime('2017-05-31'),]);
$range5 = \Danoha\DateRange::wrap([new \DateTime('2017-06-01'), new \DateTime('2018-05-31'),]);
$range6 = \Danoha\DateRange::wrap([new \DateTime('2017-06-02'), new \DateTime('2018-05-31'),]);

Assert::equal([
    'from' => NULL,
    'to' => NULL,
], $range1->join($range2)->unwrap());

Assert::equal([
    'from' => NULL,
    'to' => NULL,
], $range2->join($range3)->unwrap());

Assert::equal([
    'from' => NULL,
    'to' => new \DateTime('2017-12-01'),
], $range2->join($range4)->unwrap());

Assert::equal([
    'from' => new \DateTime('2016-06-01'),
    'to' => NULL,
], $range3->join($range4)->unwrap());

Assert::equal([
    'from' => new \DateTime('2016-06-01'),
    'to' => NULL,
], $range4->join($range3)->unwrap());

Assert::same([
    'from' => NULL,
    'to' => NULL,
], $range1->join($range1)->unwrap());

Assert::equal([
    'from' => new \DateTime('2016-06-01'),
    'to' => new \DateTime('2018-05-31'),
], $range4->join($range5)->unwrap());

Assert::null($range4->join($range6));
