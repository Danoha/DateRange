<?php

require_once './../bootstrap.php';
use Tester\Assert;

Assert::same([], (new \Danoha\DateRangeCollection([]))->join()->unwrap());

Assert::equal([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
]))->join()->unwrap());

Assert::equal([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2017-12-31'),],
], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-31'),],
]))->join()->unwrap());

Assert::equal([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-30'),],
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-30'),],
]))->join()->unwrap());

Assert::equal([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-30'),],
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
], (new \Danoha\DateRangeCollection([
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2016-12-30'),],
]))->join([
    ['from' => new \DateTime('2017-01-01'), 'to' => new \DateTime('2017-12-31'),],
    ['from' => new \DateTime('2015-01-01'), 'to' => new \DateTime('2015-12-31'),],
])->unwrap());