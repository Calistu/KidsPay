<?php

/**
 * Class Rectangle
 */
class Rectangle
{
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    public $x, $y, $w, $h;
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $xe, $ye;

    /**
     * Rectangle constructor.
     * @param $aX
     * @param $aY
     * @param $aWidth
     * @param $aHeight
     */
    public function __construct($aX, $aY, $aWidth, $aHeight)
    {
        $this->x = $aX;
        $this->y = $aY;
        $this->w = $aWidth;
        $this->h = $aHeight;
        $this->xe = $aX + $aWidth - 1;
        $this->ye = $aY + $aHeight - 1;
    }
}