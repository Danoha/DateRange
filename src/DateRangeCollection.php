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

            // ASC by from (NULL first)
            if ($fromA < $fromB) {
                return -1;
            } else if ($fromA > $fromB) {
                return 1;
            }

            // ASC by to (NULL last)
            if (($toA && $toB) ? $toA < $toB : $toA > $toB) {
                return -1;
            } else if (($toA && $toB) ? $toA > $toB : $toA < $toB) {
                return 1;
            }

            return 0;
        });
	}

	/**
	 * @internal
	 * @param array|DateRangeCollection $collection
	 * @return static
     * @throws \InvalidArgumentException
	 */
	public static function wrap($collection) {
		if ($collection instanceof DateRangeCollection) {
			return $collection;
		}

		return new static($collection);
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
     * @param \DateTime $date
     * @return bool
     */
    public function includes(\DateTime $date)
    {
        foreach ($this->ranges as $range) {
            if ($range->includes($date)) {
                return TRUE;
            }
        }

        return FALSE;
    }

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
}