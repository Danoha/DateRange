<?php

require_once './../bootstrap.php';
use Tester\Assert;

$range1 = \Danoha\DateRange::wrap([NULL, NULL,]);
$range2 = \Danoha\DateRange::wrap([NULL, new \DateTime('2017-12-01'),]);
$range3 = \Danoha\DateRange::wrap([new \DateTime('2017-01-01'), NULL,]);
$range4 = \Danoha\DateRange::wrap([new \DateTime('2016-06-01'), new \DateTime('2017-05-31'),]);
$range5 = \Danoha\DateRange::wrap([new \DateTime('2017-06-01'), new \DateTime('2018-05-31'),]);
$range6 = \Danoha\DateRange::wrap([new \DateTime('2017-01-01'), new \DateTime('2017-05-31'),]);

Assert::equal([
    ['from' => new \DateTime('2017-12-02'), 'to' => NULL,],
], $range1->subtract($range2)->unwrap());

Assert::equal([
    ['from' => NULL, 'to' => new \DateTime('2016-12-31'),],
], $range2->subtract($range3)->unwrap());

Assert::equal([
    ['from' => NULL, 'to' => new \DateTime('2016-05-31'),],
    ['from' => new \DateTime('2017-06-01'), 'to' => new \DateTime('2017-12-01'),],
], $range2->subtract($range4)->unwrap());

Assert::equal([
    ['from' => new \DateTime('2017-06-01'), 'to' => NULL,],
], $range3->subtract($range4)->unwrap());

Assert::equal([
    ['from' => new \DateTime('2016-06-01'), 'to' => new \DateTime('2016-12-31'),],
], $range4->subtract($range3)->unwrap());

Assert::same([], $range1->subtract($range1)->unwrap());

Assert::equal([
    ['from' => new \DateTime('2016-06-01'), 'to' => new \DateTime('2017-05-31'),],
], $range4->subtract($range5)->unwrap());

Assert::equal([
	['from' => new \DateTime('2017-06-01'), 'to' => NULL,],
], $range3->subtract($range6)->unwrap());