<?php

//===================================================
// CLASS LineProperty
// Description: Holds properties for a line
//===================================================

/**
 * Class LineProperty
 */
class LineProperty
{
    /**
     * @var int
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    public $iWeight = 1, $iColor = 'black', $iStyle = 'solid', $iShow = false;

    /**
     * LineProperty constructor.
     * @param int $aWeight
     * @param string $aColor
     * @param string $aStyle
     */
    public function __construct($aWeight = 1, $aColor = 'black', $aStyle = 'solid')
    {
        $this->iWeight = $aWeight;
        $this->iColor = $aColor;
        $this->iStyle = $aStyle;
    }

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->iWeight = $aWeight;
    }

    /**
     * @param $aStyle
     */
    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    /**
     * @param bool $aShow
     */
    public function Show($aShow = true)
    {
        $this->iShow = $aShow;
    }

    /**
     * @param $aImg
     * @param $aX1
     * @param $aY1
     * @param $aX2
     * @param $aY2
     */
    public function Stroke($aImg, $aX1, $aY1, $aX2, $aY2)
    {
        if ($this->iShow) {
            $aImg->PushColor($this->iColor);
            $oldls = $aImg->line_style;
            $oldlw = $aImg->line_weight;
            $aImg->SetLineWeight($this->iWeight);
            $aImg->SetLineStyle($this->iStyle);
            $aImg->StyleLine($aX1, $aY1, $aX2, $aY2);
            $aImg->PopColor($this->iColor);
            $aImg->line_style = $oldls;
            $aImg->line_weight = $oldlw;

        }
    }
}