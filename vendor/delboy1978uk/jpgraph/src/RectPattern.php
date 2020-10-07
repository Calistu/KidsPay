<?php

/**
 * Class RectPattern
 */
class RectPattern
{
    /**
     * @var
     */
    protected $color;
    /**
     * @var int
     */
    protected $weight;
    /**
     * @var null
     */
    protected $rect = null;
    /**
     * @var bool
     */
    protected $doframe = true;
    /**
     * @var
     */
    protected $linespacing; // Line spacing in pixels
    /**
     * @var int
     */
    protected $iBackgroundColor = -1;  // Default is no background fill

    /**
     * RectPattern constructor.
     * @param $aColor
     * @param int $aWeight
     */
    public function __construct($aColor, $aWeight = 1)
    {
        $this->color = $aColor;
        $this->weight = $aWeight;
    }

    /**
     * @param $aBackgroundColor
     */
    public function SetBackground($aBackgroundColor)
    {
        $this->iBackgroundColor = $aBackgroundColor;
    }

    /**
     * @param $aRect
     */
    public function SetPos($aRect)
    {
        $this->rect = $aRect;
    }

    /**
     * @param bool $aShow
     */
    public function ShowFrame($aShow = true)
    {
        $this->doframe = $aShow;
    }

    /**
     * @param $aDens
     * @throws JpGraphExceptionL
     */
    public function SetDensity($aDens)
    {
        if ($aDens < 1 || $aDens > 100)
            JpGraphError::RaiseL(16001, $aDens);
        //(" Desity for pattern must be between 1 and 100. (You tried $aDens)");
        // 1% corresponds to linespacing=50
        // 100 % corresponds to linespacing 1
        $this->linespacing = floor(((100 - $aDens) / 100.0) * 50) + 1;

    }

    /**
     * @param $aImg
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg)
    {
        if ($this->rect == null)
            JpGraphError::RaiseL(16002);
        //(" No positions specified for pattern.");

        if (!(is_numeric($this->iBackgroundColor) && $this->iBackgroundColor == -1)) {
            $aImg->SetColor($this->iBackgroundColor);
            $aImg->FilledRectangle($this->rect->x, $this->rect->y, $this->rect->xe, $this->rect->ye);
        }

        $aImg->SetColor($this->color);
        $aImg->SetLineWeight($this->weight);

        // Virtual function implemented by subclass
        $this->DoPattern($aImg);

        // Frame around the pattern area
        if ($this->doframe)
            $aImg->Rectangle($this->rect->x, $this->rect->y, $this->rect->xe, $this->rect->ye);
    }

}

