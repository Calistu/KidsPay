<?php

/**
 * Class PlotLine
 */
class PlotLine
{
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $scaleposition, $direction = -1;
    /**
     * @var int
     */
    protected $weight = 1;
    /**
     * @var string
     */
    protected $color = 'black';
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $legend = '', $hidelegend = false, $legendcsimtarget = '', $legendcsimalt = '', $legendcsimwintarget = '';
    /**
     * @var string
     */
    private $iLineStyle = 'solid';
    /**
     * @var int
     */
    public $numpoints = 0; // Needed since the framework expects this property

    /**
     * PlotLine constructor.
     * @param int $aDir
     * @param int $aPos
     * @param string $aColor
     * @param int $aWeight
     */
    public function __construct($aDir = HORIZONTAL, $aPos = 0, $aColor = 'black', $aWeight = 1)
    {
        $this->direction = $aDir;
        $this->color = $aColor;
        $this->weight = $aWeight;
        $this->scaleposition = $aPos;
    }

    /**
     * @param $aLegend
     * @param string $aCSIM
     * @param string $aCSIMAlt
     * @param string $aCSIMWinTarget
     */
    public function SetLegend($aLegend, $aCSIM = '', $aCSIMAlt = '', $aCSIMWinTarget = '')
    {
        $this->legend = $aLegend;
        $this->legendcsimtarget = $aCSIM;
        $this->legendcsimwintarget = $aCSIMWinTarget;
        $this->legendcsimalt = $aCSIMAlt;
    }

    /**
     * @param bool $f
     */
    public function HideLegend($f = true)
    {
        $this->hidelegend = $f;
    }

    /**
     * @param $aScalePosition
     */
    public function SetPosition($aScalePosition)
    {
        $this->scaleposition = $aScalePosition;
    }

    /**
     * @param $aDir
     */
    public function SetDirection($aDir)
    {
        $this->direction = $aDir;
    }

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->color = $aColor;
    }

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    /**
     * @param $aStyle
     */
    public function SetLineStyle($aStyle)
    {
        $this->iLineStyle = $aStyle;
    }

    /**
     * @return string
     */
    public function GetCSIMAreas()
    {
        return '';
    }

    //---------------
    // PRIVATE METHODS

    /**
     * @param $graph
     */
    public function DoLegend($graph)
    {
        if (!$this->hidelegend) $this->Legend($graph);
    }

    // Framework function the chance for each plot class to set a legend

    /**
     * @param $aGraph
     * @throws JpGraphExceptionL
     */
    public function Legend($aGraph)
    {
        if ($this->legend != '') {
            $dummyPlotMark = new PlotMark();
            $lineStyle = 1;
            $aGraph->legend->Add($this->legend, $this->color, $dummyPlotMark, $lineStyle,
                $this->legendcsimtarget, $this->legendcsimalt, $this->legendcsimwintarget);
        }
    }

    /**
     * @param $aGraph
     */
    public function PreStrokeAdjust($aGraph)
    {
        // Nothing to do
    }

    // Called by framework to allow the object to draw
    // optional information in the margin area
    /**
     * @param $aImg
     */
    public function StrokeMargin($aImg)
    {
        // Nothing to do
    }

    // Framework function to allow the object to adjust the scale

    /**
     * @param $aGraph
     */
    public function PrescaleSetup($aGraph)
    {
        // Nothing to do
    }

    /**
     * @return array
     */
    public function Min()
    {
        return array(null, null);
    }

    /**
     * @return array
     */
    public function Max()
    {
        return array(null, null);
    }

    /**
     * @param $aImg
     * @param $aMinX
     * @param $aMinY
     * @param $aMaxX
     * @param $aMaxY
     * @param $aXPos
     * @param $aYPos
     * @throws JpGraphExceptionL
     */
    public function _Stroke($aImg, $aMinX, $aMinY, $aMaxX, $aMaxY, $aXPos, $aYPos)
    {
        $aImg->SetColor($this->color);
        $aImg->SetLineWeight($this->weight);
        $oldStyle = $aImg->SetLineStyle($this->iLineStyle);
        if ($this->direction == VERTICAL) {
            $ymin_abs = $aMinY;
            $ymax_abs = $aMaxY;
            $xpos_abs = $aXPos;
            $aImg->StyleLine($xpos_abs, $ymin_abs, $xpos_abs, $ymax_abs);
        } elseif ($this->direction == HORIZONTAL) {
            $xmin_abs = $aMinX;
            $xmax_abs = $aMaxX;
            $ypos_abs = $aYPos;
            $aImg->StyleLine($xmin_abs, $ypos_abs, $xmax_abs, $ypos_abs);
        } else {
            JpGraphError::RaiseL(25125);//(" Illegal direction for static line");
        }
        $aImg->SetLineStyle($oldStyle);
    }

    /**
     * @param $aImg
     * @param $aXScale
     * @param $aYScale
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg, $aXScale, $aYScale)
    {
        $this->_Stroke($aImg,
            $aImg->left_margin,
            $aYScale->Translate($aYScale->GetMinVal()),
            $aImg->width - $aImg->right_margin,
            $aYScale->Translate($aYScale->GetMaxVal()),
            $aXScale->Translate($this->scaleposition),
            $aYScale->Translate($this->scaleposition)
        );
    }
}
