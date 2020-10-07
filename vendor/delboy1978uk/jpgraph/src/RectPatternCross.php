<?php

class RectPatternCross extends RectPattern
{
    /**
     * @var RectPatternVert|null
     */
    private $vert = null;
    /**
     * @var RectPatternHor|null
     */
    private $hor = null;

    /**
     * RectPatternCross constructor.
     * @param string $aColor
     * @param int $aWeight
     */
    public function __construct($aColor = "black", $aWeight = 1)
    {
        parent::__construct($aColor, $aWeight);
        $this->vert = new RectPatternVert($aColor, $aWeight);
        $this->hor = new RectPatternHor($aColor, $aWeight);
    }

    /**
     * @param $aDepth
     */
    public function SetOrder($aDepth)
    {
        $this->vert->SetOrder($aDepth);
        $this->hor->SetOrder($aDepth);
    }

    /**
     * @param $aRect
     */
    public function SetPos($aRect)
    {
        parent::SetPos($aRect);
        $this->vert->SetPos($aRect);
        $this->hor->SetPos($aRect);
    }

    /**
     * @param $aDens
     * @throws JpGraphExceptionL
     */
    public function SetDensity($aDens)
    {
        $this->vert->SetDensity($aDens);
        $this->hor->SetDensity($aDens);
    }

    /**
     * @param $aImg
     */
    public function DoPattern($aImg)
    {
        $this->vert->DoPattern($aImg);
        $this->hor->DoPattern($aImg);
    }
}

