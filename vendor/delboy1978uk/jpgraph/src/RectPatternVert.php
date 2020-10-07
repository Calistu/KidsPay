<?php

/**
 * Class RectPatternVert
 */
class RectPatternVert extends RectPattern
{
    /**
     * RectPatternVert constructor.
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
        $x = $this->rect->x;
        $y0 = $this->rect->y;
        $y1 = $this->rect->ye;
        while ($x < $this->rect->xe) {
            $aImg->Line($x, $y0, $x, $y1);
            $x += $this->linespacing;
        }
    }
}