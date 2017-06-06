<?php

namespace Danoha;


class DateRangeCollection {

	/** @var DateRange[] */
    protected $ranges = [];

	/**
	 * @param array $collection
     * @throws \InvalidArgumentException
	 */
	public function __construct($collection) {
		foreach ($collection as $item) {
			$this->ranges[] = DateRange::wrap($item);
		}

        usort($this->ranges, function (DateRange $a, DateRange $b) {
            $fromA = $a->getFrom();
            $fromB = $b->getFrom();
            $toA = $a->getTo();
            $toB = $b->getTo();

            // by from (NULL first)
            if (!$fromA && $fromB) {
                return -1;
            } else if ($fromA && !$fromB) {
                return 1;
            } else if ($fromA && $fromB) {
                // ASC by from
                if ($fromA < $fromB) {
                    return -1;
                } else if ($fromA > $fromB) {
                    return 1;
                }
            }

            // by to (NULL last)
            if (!$toA && $toB) {
                return 1;
            } else if ($toA && !$toB) {
                return -1;
            } else if ($toA && $toB) {
                // ASC by to
                if ($toA < $toB) {
                    return -1;
                } else if ($toA > $toB) {
                    return 1;
                }
            }

            return 0;
        });
	}

    /**
     * @return array
     */
    public function unwrap() {
        return array_map(function (DateRange $range) {
            return $range->unwrap();
        }, $this->ranges);
	}

    /**
     * @param array $ranges
     * @return static
     */
    public function add(array $ranges)
    {
        return new static(
            array_merge(
                $this->ranges,
                $ranges
            )
        );
    }

    /**
     * @param \DateTime|array|DateRange $dateOrRange
     * @return bool
     */
    public function includes($dateOrRange)
    {
        foreach ($this->ranges as $range) {
            if ($range->includes($dateOrRange)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * @param array|DateRangeCollection $coll
     * @return static
     */
    public function intersect($coll)
    {
        $left = $this->ranges;
        $right = static::wrap($coll)->ranges;

        $ranges = [];
        foreach ($left as $leftRange) {
            foreach ($right as $rightRange) {
                $intersection = $leftRange->intersect($rightRange);
                if ($intersection) {
                    $ranges[] = $intersection;
                }
            }
        }

        return (new static($ranges))->join();
    }

    /**
     * @internal
     * @param array|DateRangeCollection $collection
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function wrap($collection)
    {
        if ($collection instanceof DateRangeCollection) {
            return $collection;
        }

        return new static($collection);
    }

    /**
     * @return static
     */
    public function join()
    {
        $ranges = $this->ranges;

        for ($i = 0; $i < count($ranges); $i++) {
            $a = $ranges[$i];

            foreach (array_slice($ranges, 0) as $j => $b) {
                if ($i === $j) {
                    continue;
                }

                $join = $a->join($b);

                if ($join) {
                    $ranges[$i] = $a = $join;
                    array_splice($ranges, $j, 1);
                }
            }
        }

        return new static(array_filter($ranges));
	}

    /**
     * @param array|DateRangeCollection $subtrahends
     * @return static
     */
    public function subtract($subtrahends)
    {
        $minuends = $this->ranges;
        $subtrahends = static::wrap($subtrahends)->ranges;

        foreach ($subtrahends as $subtrahend) {
            $offset = 0;
            /** @var DateRange $minuend */
            foreach (array_slice($minuends, 0) as $i => $minuend) {
                $differences = $minuend->subtract($subtrahend);
                array_splice($minuends, $offset + $i, 1, $differences->ranges);
                $offset += count($differences->ranges) - 1;
            }
        }

        return new static($minuends);
    }
}