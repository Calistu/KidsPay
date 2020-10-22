<?php

/**
 * Class PlotBand
 */
class PlotBand
{
    /**
     * @var int
     */
    public $depth; // Determine if band should be over or under the plots
    /**
     * @var RectPattern3DPlane|RectPatternCross|RectPatternHor|RectPatternLDiag|RectPatternRDiag|RectPatternSolid|RectPatternVert|null
     */
    private $prect = null;
    /**
     * @var
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    private $dir, $min, $max;

    /**
     * PlotBand constructor.
     * @param $aDir
     * @param $aPattern
     * @param $aMin
     * @param $aMax
     * @param string $aColor
     * @param int $aWeight
     * @param int $aDepth
     * @throws JpGraphExceptionL
     */
    public function __construct($aDir, $aPattern, $aMin, $aMax, $aColor = "black", $aWeight = 1, $aDepth = DEPTH_BACK)
    {
        $f = new RectPatternFactory();
        $this->prect = $f->Create($aPattern, $aColor, $aWeight);
        if (is_numeric($aMin) && is_numeric($aMax) && ($aMin > $aMax))
            JpGraphError::RaiseL(16004);
        //('Min value for plotband is larger than specified max value. Please correct.');
        $this->dir = $aDir;
        $this->min = $aMin;
        $this->max = $aMax;
        $this->depth = $aDepth;
    }

    // Set position. aRect contains absolute image coordinates

    /**
     * @param $aRect
     */
    public function SetPos($aRect)
    {
        assert($this->prect != null);
        $this->prect->SetPos($aRect);
    }

    /**
     * @param bool $aFlag
     */
    public function ShowFrame($aFlag = true)
    {
        $this->prect->ShowFrame($aFlag);
    }

    // Set z-order. In front of pplot or in the back

    /**
     * @param $aDepth
     */
    public function SetOrder($aDepth)
    {
        $this->depth = $aDepth;
    }

    /**
     * @param $aDens
     * @throws JpGraphExceptionL
     */
    public function SetDensity($aDens)
    {
        $this->prect->SetDensity($aDens);
    }

    /**
     * @return int|string
     */
    public function GetDir()
    {
        return $this->dir;
    }

    /**
     * @return int|string
     */
    public function GetMin()
    {
        return $this->min;
    }

    /**
     * @return int|string
     */
    public function GetMax()
    {
        return $this->max;
    }

    /**
     * @param $aGraph
     */
    public function PreStrokeAdjust($aGraph)
    {
        // Nothing to do
    }

    // Display band

    /**
     * @param $aImg
     * @param $aXScale
     * @param $aYScale
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg, $aXScale, $aYScale)
    {
        assert($this->prect != null);
        if ($this->dir == HORIZONTAL) {
            if ($this->min === 'min') $this->min = $aYScale->GetMinVal();
            if ($this->max === 'max') $this->max = $aYScale->GetMaxVal();

            // Only draw the bar if it actually appears in the range
            if ($this->min < $aYScale->GetMaxVal() && $this->max > $aYScale->GetMinVal()) {

                // Trucate to limit of axis
                $this->min = max($this->min, $aYScale->GetMinVal());
                $this->max = min($this->max, $aYScale->GetMaxVal());

                $x = $aXScale->scale_abs[0];
                $y = $aYScale->Translate($this->max);
                $width = $aXScale->scale_abs[1] - $aXScale->scale_abs[0] + 1;
                $height = abs($y - $aYScale->Translate($this->min)) + 1;
                $this->prect->SetPos(new Rectangle($x, $y, $width, $height));
                $this->prect->Stroke($aImg);
            }
        } else { // VERTICAL
            if ($this->min === 'min') $this->min = $aXScale->GetMinVal();
            if ($this->max === 'max') $this->max = $aXScale->GetMaxVal();

            // Only draw the bar if it actually appears in the range
            if ($this->min < $aXScale->GetMaxVal() && $this->max > $aXScale->GetMinVal()) {

                // Trucate to limit of axis
                $this->min = max($this->min, $aXScale->GetMinVal());
                $this->max = min($this->max, $aXScale->GetMaxVal());

                $y = $aYScale->scale_abs[1];
                $x = $aXScale->Translate($this->min);
                $height = abs($aYScale->scale_abs[1] - $aYScale->scale_abs[0]);
                $width = abs($x - $aXScale->Translate($this->max));
                $this->prect->SetPos(new Rectangle($x, $y, $width, $height));
                $this->prect->Stroke($aImg);
            }
        }
    }
}