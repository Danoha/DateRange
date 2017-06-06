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
     * @return array
     */
    public function unwrap() {
        return [
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
        ];
	}

	/**
	 * @internal
	 * @param array|DateRange $range
	 * @return static
     * @throw \InvalidArgumentException
	 */
	public static function wrap($range) {
		if ($range instanceof DateRange) {
			return $range;
		}

		if (
		    is_array($range)
            &&
            array_key_exists('from', $range)
            &&
            array_key_exists('to', $range)
        ) {
		    return new DateRange($range['from'], $range['to']);
        }

        if (
            is_array($range)
            &&
            count($range) === 2
            &&
            array_key_exists(0, $range)
            &&
            array_key_exists(1, $range)
        ) {
            return new DateRange($range[0], $range[1]);
        }

		throw new \InvalidArgumentException('Expected array with from and to or exactly 2 items');
	}
}