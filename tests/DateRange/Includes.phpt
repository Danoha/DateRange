<?php

require_once './../bootstrap.php';
use Tester\Assert;

$range1 = \Danoha\DateRange::wrap([
    new \DateTime('2017-01-01'),
    new \DateTime('2017-12-31'),
]);

Assert::false($range1->includes(new \DateTime('2016-12-31')));
Assert::true($range1->includes(new \DateTime('2017-01-01')));
Assert::true($range1->includes(new \DateTime('2017-02-01')));
Assert::true($range1->includes(new \DateTime('2017-03-01')));
Assert::true($range1->includes(new \DateTime('2017-04-01')));
Assert::true($range1->includes(new \DateTime('2017-05-01')));
Assert::true($range1->includes(new \DateTime('2017-06-01')));
Assert::true($range1->includes(new \DateTime('2017-07-01')));
Assert::true($range1->includes(new \DateTime('2017-08-01')));
Assert::true($range1->includes(new \DateTime('2017-09-01')));
Assert::true($range1->includes(new \DateTime('2017-10-01')));
Assert::true($range1->includes(new \DateTime('2017-11-01')));
Assert::true($range1->includes(new \DateTime('2017-12-01')));
Assert::true($range1->includes(new \DateTime('2017-12-31')));
Assert::false($range1->includes(new \DateTime('2018-01-01')));

$range2 = \Danoha\DateRange::wrap([
    new \DateTime('2017-01-01'),
    NULL,
]);

Assert::false($range2->includes(new \DateTime('2016-12-31')));
Assert::true($range2->includes(new \DateTime('2017-01-01')));
Assert::true($range2->includes(new \DateTime('2017-06-01')));
Assert::true($range2->includes(new \DateTime('2018-01-01')));
Assert::true($range2->includes(new \DateTime('2020-01-01')));
Assert::true($range2->includes(new \DateTime('2025-01-01')));
Assert::true($range2->includes(new \DateTime('2030-01-01')));


$range3 = \Danoha\DateRange::wrap([
    NULL,
    new \DateTime('2017-12-31'),
]);

Assert::true($range3->includes(new \DateTime('2005-01-01')));
Assert::true($range3->includes(new \DateTime('2010-01-01')));
Assert::true($range3->includes(new \DateTime('2015-01-01')));
Assert::true($range3->includes(new \DateTime('2016-01-01')));
Assert::true($range3->includes(new \DateTime('2017-06-01')));
Assert::true($range3->includes(new \DateTime('2017-12-31')));
Assert::false($range3->includes(new \DateTime('2018-01-01')));

$range4 = \Danoha\DateRange::wrap([
    NULL,
    NULL,
]);

Assert::true($range4->includes(new \DateTime('2005-01-01')));
Assert::true($range4->includes(new \DateTime('2010-01-01')));
Assert::true($range4->includes(new \DateTime('2015-01-01')));
Assert::true($range4->includes(new \DateTime('2016-01-01')));
Assert::true($range2->includes(new \DateTime('2017-01-01')));
Assert::true($range2->includes(new \DateTime('2017-06-01')));
Assert::true($range2->includes(new \DateTime('2018-01-01')));
Assert::true($range2->includes(new \DateTime('2020-01-01')));
Assert::true($range2->includes(new \DateTime('2025-01-01')));
Assert::true($range2->includes(new \DateTime('2030-01-01')));
