# DateRange

__Working with date ranges made easy.__

## Installation

Works best with composer. :ok_hand:

```bash
composer require danoha/date-range
```

If you do not use composer or its autoloading, require
`src/DateRange.php` and `src/DateRangeCollection.php`.

Then use `\Danoha\DateRange` and `\Danoha\DateRangeCollection` classes
directly in your code.

## Usage

Working with date range:

```php
$range = new \Danoha\DateRange($from, $to); // any parameter can be NULL
$range
    ->join($thatRange)
    ->intersect([ $from, $to ]) // methods accepting range also accept array
    ->contains($currentDate);
```

Work with date range collection:

```php
$coll = new \Danoha\DateRangeCollection([
    [ $from, $to ], // two items per range accepted
    [ 'from' => $from, 'to' => $to, ], // accepted too
    
    [ $from, NULL, ], // NULL means indefinite interval
    [ NULL, NULL, ], // and can be used on both sides
]);

$coll
    ->join($thatCollection)
    ->intersect([ $range1, $range2 ]) // methods accepting collection also accept array
    ->contains($someRange);
```

To get your ranges back:

```php
$coll->getRanges() === [
    new \Danoha\DateRange($from, $to),
    new \Danoha\DateRange($from, NULL),
];

$coll->unwrap() === [
    [ 'from' => $from, 'to' => $to, ], // every range has this exact format
    [ 'from' => $from, 'to' => NULL, ], // regardless of what was passed to constructor
    ...
];
```

Every method that accepts collection also accepts
array of ranges (which can be arrays, too):

```php
$coll->intersect(
    // another collection
    new \Danoha\DateRangeCollection([ ... ])
);

$coll->intersect([
    // inlined collection (same as constructor)
    [ 'from' => $from, 'to' => $to, ]
]);
```

Note: definite intervals are handled as inclusive on both sides.

## Available range methods

Note: all methods returning range return new instance.
That means calling `$range->join(...)` twice on the same
range will create two instances and neither of them will
contain both joined ranges.

- getFrom - returns first date in range,
- getTo - returns last date in range,
- unwrap - get range in array format,
- intersect - finds intersection between current and given range,
- overlaps - tests if current and given range overlap,
- join - finds common range between current and given range,
- isRightAfter - tests if current range is right after given range,
- isRightBefore - tests if current range is right before given range,
- subtract - returns collection of differences between current and given range,
- includes - tests if range includes given date or range,
- includesDate - tests if range includes given date,
- includesRange - tests if range includes given range,
- equals - tests if current range is equal to given range.

## Available collection methods

Note: all methods returning collection return new instance.
That means calling `$coll->add(...)` twice on the same
collection will create two instances and neither of them will
contain both added ranges.

- getRanges - get ranges in current collection,
- unwrap - get underlying date ranges in array format,
- add - add given ranges to collection,
- includes - tests if collection includes given date or range,
- join - joins ranges in current collection if possible,
- intersect - calculates all intersections with given ranges,
- subtract - subtracts given ranges from current collection.