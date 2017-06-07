# DateRange

__Working with date ranges made easy.__

## Usage

Create date range collection:

```
$coll = new \Danoha\DateRangeCollection([
    [ $from, $to ], // two items per range accepted
    [ 'from' => $from, 'to' => $to, ], // accepted too
    
    [ $from, NULL, ], // NULL means indefinite interval
    [ NULL, NULL, ], // and can be used on both sides
]);
```

To get your ranges back:

```
$coll->unwrap() === [
    [ 'from' => $from, 'to' => $to, ], // every range has this exact format
    [ 'from' => $from, 'to' => $to, ], // regardless of what was passed to constructor
    ...
]
```

Every method accepts collection or array of ranges:

```
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