<?php

require_once './../bootstrap.php';
use Tester\Assert;

Assert::same([], (new \Danoha\DateRangeCollection([]))->intersect([])->unwrap());

Assert::same([], (new \Danoha\DateRangeCollection([]))->intersect([
    ['from' => new \DateTime('2017-12-01'), 'to' => new \DateTime('2018-01-31'),],
])->unwrap());

Assert::same([], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-12-01'), 'to' => new \DateTime('2018-01-31'),],
]))->intersect([])->unwrap());

Assert::equal([], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
]))->intersect([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
])->unwrap());

Assert::equal([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
]))->intersect([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-31'),],
])->unwrap());

Assert::equal([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-01-31'),],
    ['from' => new \DateTime('2016-12-01'), 'to' => new \DateTime('2017-01-31'),],
    ['from' => new \DateTime('2017-12-01'), 'to' => new \DateTime('2017-12-31'),],
], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-31'),],
]))->intersect([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-01-31'),],
    ['from' => new \DateTime('2016-12-01'), 'to' => new \DateTime('2017-01-31'),],
    ['from' => new \DateTime('2017-12-01'), 'to' => new \DateTime('2018-01-31'),],
])->unwrap());