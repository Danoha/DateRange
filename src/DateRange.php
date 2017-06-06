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
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return \DateTime|NULL
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return array
     */
    public function unwrap()
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
        ];
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function includes(\DateTime $date)
    {
        if ($this->from && $this->to) {
            return $date >= $this->from && $date <= $this->to;
        } else if ($this->from && !$this->to) {
            return $date >= $this->from;
        } else if (!$this->from && $this->to) {
            return $date <= $this->to;
        }

        return TRUE;
    }

    /**
     * @param array|DateRange $b
     * @return static|NULL
     */
    public function intersect($b)
    {
        $a = $this;
        $b = static::wrap($b);

        if (!$a->overlaps($b)) {
            return NULL;
        }

        $from = max($a->from, $b->from);
        $to = min($a->to, $b->to) ?: max($a->to, $b->to);

        return new static($from, $to);
    }

    /**
     * @internal
     * @param array|DateRange $range
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function wrap($range)
    {
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

    /**
     * @param array|DateRange $b
     * @return bool
     */
    public function overlaps($b)
    {
        $a = $this;
        $b = static::wrap($b);

        return
            (!$a->from || !$b->to || $a->from <= $b->to)
            &&
            (!$a->to || !$b->from || $a->to >= $b->from);
    }

    /**
     * @param array|DateRange $b
     * @return static|NULL
     */
    public function join($b)
    {
        $a = $this;
        $b = static::wrap($b);

        if (!$a->overlaps($b) && !$a->isRightAfter($b) && !$a->isRightBefore($b)) {
            return NULL;
        }

        $from = min($a->from, $b->from);
        $to = (!$a->to || !$b->to) ? NULL : max($a->to, $b->to);

        return new static($from, $to);
    }

    /**
     * @param array|DateRange $b
     * @return bool
     */
    public function isRightAfter($b)
    {
        $a = $this;
        $b = static::wrap($b);

        return
            $b->to
            &&
            $a->from
            &&
            (
                (clone $b->to)
                    ->modify('midnight, +1 day')
                    ->format('Y-m-d') === $a->from->format('Y-m-d')
            );
    }

    /**
     * @param array|DateRange $b
     * @return bool
     */
    public function isRightBefore($b)
    {
        return static::wrap($b)->isRightAfter($this);
    }
}