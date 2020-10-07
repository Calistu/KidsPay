<?php

/**
 * Class RectPatternSolid
 */
class RectPatternSolid extends RectPattern
{

    /**
     * RectPatternSolid constructor.
     * @param string $aColor
     * @param int $aWeight
     */
    public function __construct($aColor = "black", $aWeight = 1)
    {
        parent::__construct($aColor, $aWeight);
    }

    /**
     * @param $aImg
     */
    public function DoPattern($aImg)
    {
        $aImg->SetColor($this->color);
        $aImg->FilledRectangle($this->rect->x, $this->rect->y,
            $this->rect->xe, $this->rect->ye);
    }
}