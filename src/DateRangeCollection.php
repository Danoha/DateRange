<?php

namespace Danoha;


class DateRangeCollection {

	/** @var DateRange[] */
	protected $ranges;

	/**
	 * @param array $collection
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
	 */
	public static function wrap($collection) {
		if ($collection instanceof DateRangeCollection) {
			return $collection;
		}

		return new static($collection);
	}

	public function intersect($collection) {
		$collection = static::wrap($collection);


	}
}