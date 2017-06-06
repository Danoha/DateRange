<?php

namespace Danoha;


class DateRangeCollection {

	/** @var DateRange[] */
	protected $ranges;

	/**
	 * @param array $collection
     * @throws \InvalidArgumentException
	 */
	public function __construct($collection) {
		foreach ($collection as $item) {
			$this->ranges[] = DateRange::wrap($item);
		}
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

	public function intersect($collection) {


	}
}