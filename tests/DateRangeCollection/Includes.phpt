<?php

require_once './../bootstrap.php';
use Tester\Assert;

$coll = new \Danoha\DateRangeCollection([
    [new \DateTime('2017-01-01'), new \DateTime('2017-12-31'),],
    [new \DateTime('2015-01-01'), new \DateTime('2015-12-31'),],
]);

Assert::false($coll->includes(new \DateTime('2014-12-31')));
Assert::true($coll->includes(new \DateTime('2015-01-01')));
Assert::false($coll->includes(new \DateTime('2016-12-31')));
Assert::true($coll->includes(new \DateTime('2017-02-01')));
Assert::false($coll->includes(new \DateTime('2018-01-01')));
