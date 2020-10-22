<?php

//===================================================
// CLASS JpgTimer
// Description: General timing utility class to handle
// time measurement of generating graphs. Multiple
// timers can be started.
//===================================================

/**
 * Class JpgTimer
 */
class JpgTimer
{
    /**
     * @var
     */
    /**
     * @var int
     */
    private $start, $idx;

    /**
     * JpgTimer constructor.
     */
    public function __construct()
    {
        $this->idx = 0;
    }

    // Push a new timer start on stack

    /**
     *
     */
    public function Push()
    {
        list($ms, $s) = explode(" ", microtime());
        $this->start[$this->idx++] = floor($ms * 1000) + 1000 * $s;
    }

    // Pop the latest timer start and return the diff with the
    // current time
    /**
     * @return float|int
     */
    public function Pop()
    {
        assert($this->idx > 0);
        list($ms, $s) = explode(" ", microtime());
        $etime = floor($ms * 1000) + (1000 * $s);
        $this->idx--;
        return $etime - $this->start[$this->idx];
    }
} 