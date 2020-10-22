<?php

/**
 * Class RectPatternHor
 */
class RectPatternHor extends RectPattern
{

    /**
     * RectPatternHor constructor.
     * @param string $aColor
     * @param int $aWeight
     * @param int $aLineSpacing
     */
    public function __construct($aColor = "black", $aWeight = 1, $aLineSpacing = 7)
    {
        parent::__construct($aColor, $aWeight);
        $this->linespacing = $aLineSpacing;
    }

    /**
     * @param $aImg
     */
    public function DoPattern($aImg)
    {
        $x0 = $this->rect->x;
        $x1 = $this->rect->xe;
        $y = $this->rect->y;
        while ($y < $this->rect->ye) {
            $aImg->Line($x0, $y, $x1, $y);
            $y += $this->linespacing;
        }
    }
}