<?php

require_once './../bootstrap.php';
use Tester\Assert;

Assert::same(\Danoha\DateRange::class, get_class(\Danoha\DateRange::wrap(['from' => NULL, 'to' => NULL,])));

$range = \Danoha\DateRange::wrap(['from' => NULL, 'to' => NULL,]);
Assert::same($range, \Danoha\DateRange::wrap($range));

$from = new \DateTime('2016-01-01');
$to = new \DateTime('2017-01-01');
$range = \Danoha\DateRange::wrap(['from' => $from, 'to' => $to,]);
$range2 = new \Danoha\DateRange($from, $to);
Assert::same($from, $range->getFrom());
Assert::same($to, $range->getTo());
Assert::same($from, $range2->getFrom());
Assert::same($to, $range2->getTo());
Assert::same([
    'from' => $from,
    'to' => $to,
], $range->unwrap());

Assert::same(NULL, \Danoha\DateRange::wrap([new \DateTime('2016-01-01'), NULL,])->getTo());
Assert::same(NULL, \Danoha\DateRange::wrap([NULL, new \DateTime('2016-01-01'),])->getFrom());

Assert::throws(function () {
    \Danoha\DateRange::wrap(['asd' => '',]);
}, InvalidArgumentException::class, 'Expected array with from and to or exactly 2 items');


Assert::throws(function () {
    \Danoha\DateRange::wrap(['asd',]);
}, InvalidArgumentException::class, 'Expected array with from and to or exactly 2 items');

