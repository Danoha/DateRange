<?php

namespace Danoha;

class DateRange
{

    /** @var \DateTime|NULL */
    protected $from;

    /** @var \DateTime|NULL */
    protected $to;

    /**
     * @param \DateTime|NULL $from
     * @param \DateTime|NULL $to
     */
    public function __construct(\DateTime $from = NULL, \DateTime $to = NULL)
    {
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
     * @param array|self $b
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
     * @param array|self $range
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function wrap($range)
    {
        if ($range instanceof self) {
            return $range;
        }

        if (
            is_array($range)
            &&
            array_key_exists('from', $range)
            &&
            array_key_exists('to', $range)
        ) {
            return new static($range['from'], $range['to']);
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
            return new static($range[0], $range[1]);
        }

        throw new \InvalidArgumentException('Expected array with from and to or exactly 2 items');
    }

    /**
     * @param array|self $b
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
     * @param array|self $b
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
     * @param array|self $b
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
     * @param array|self $b
     * @return bool
     */
    public function isRightBefore($b)
    {
        return static::wrap($b)->isRightAfter($this);
    }

    /**
     * @param array|self $b
     * @return DateRangeCollection
     */
    public function subtract($b)
    {
        $b = static::wrap($b);

        if (!$this->overlaps($b)) {
            return new DateRangeCollection([new static($this->from, $this->to),]);
        }

        if ($b->includes($this)) {
            return new DateRangeCollection([]);
        }

        if ($this->from != $b->from && $this->to != $b->to && $this->includes($b)) {
            // two results
            return new DateRangeCollection([
                new static($this->from, (clone $b->from)->modify('-1 day')),
                new static((clone $b->to)->modify('+1 day'), $this->to),
            ]);
        }

        if (
            ($b->from && $this->from != $b->from && $this->includes($b->from))
            ||
            ($this->to && $this->to != $b->to && $b->includes($this->to))
        ) {
            $from = $this->from;
            $to = (clone $b->from)->modify('-1 day');
        } else {
            $from = (clone $b->to)->modify('+1 day');
            $to = $this->to;
        }

        return new DateRangeCollection([new static($from, $to),]);
    }

    /**
     * @param \DateTime|array|self $dateOrRange
     * @return bool
     */
    public function includes($dateOrRange)
    {
        if ($dateOrRange instanceof \DateTime) {
            return $this->includesDate($dateOrRange);
        } else {
            return $this->includesRange($dateOrRange);
        }
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function includesDate(\DateTime $date)
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
     * @param array|self $range
     * @return bool
     */
    public function includesRange($range)
    {
        $range = static::wrap($range);

        if ($this->equals($range)) {
            return TRUE;
        }

        $includesFrom = !$this->from || ($range->from && $this->from <= $range->from);
        $includesTo = !$this->to || ($range->to && $this->to >= $range->to);
        return $includesFrom && $includesTo;
    }

    /**
     * @param array|self $b
     * @return bool
     */
    public function equals($b)
    {
        $b = static::wrap($b);
        return $this->from == $b->from && $this->to == $b->to;
    }

    /**
     * @param array|self $a
     * @param array|self $b
     * @return int
     */
    public static function compare($a, $b)
    {
        $a = static::wrap($a);
        $b = static::wrap($b);

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
    }
}
