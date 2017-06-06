<?php

require_once './../bootstrap.php';
use Tester\Assert;

Assert::same(\Danoha\DateRange::class, get_class(\Danoha\DateRange::wrap()));

$range = \Danoha\DateRange::wrap();
Assert::same($range, \Danoha\DateRange::wrap($range));

$from = new \DateTime('2016-01-01');
$to = new \DateTime('2017-01-01');
$range = \Danoha\DateRange::wrap($from, $to);
Assert::same($from, $range->getFrom());
Assert::same($to, $range->getTo());

Assert::same(NULL, \Danoha\DateRange::wrap(new \DateTime('2016-01-01'), NULL)->getTo());
Assert::same(NULL, \Danoha\DateRange::wrap(NULL, new \DateTime('2016-01-01'))->getFrom());