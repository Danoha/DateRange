<?php

namespace Danoha;

class DateRange {

	/** @var \DateTime|NULL */
	protected $from;

	/** @var \DateTime|NULL */
	protected $to;

	/**
	 * @internal
	 * @param \DateTime|NULL $from
	 * @param \DateTime|NULL $to
	 */
	protected function __construct(\DateTime $from = NULL, \DateTime $to = NULL) {
		$this->from = $from;
		$this->to = $to;
	}

	/**
	 * @return \DateTime|NULL
	 */
	public function getFrom() {
		return $this->from;
	}

	/**
	 * @return \DateTime|NULL
	 */
	public function getTo() {
		return $this->to;
	}

	/**
	 * @internal
	 * @param array|\DateTime|NULL $rangeOrFrom
	 * @param \DateTime|NULL $to
	 * @return static
	 */
	public static function wrap($rangeOrFrom = NULL, \DateTime $to = NULL) {
		if ($rangeOrFrom instanceof DateRange) {
			return $rangeOrFrom;
		}

		return new static($rangeOrFrom, $to);
	}
}