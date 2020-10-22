<?php

/**
 * Class GanttPlotObject
 */
class GanttPlotObject
{
    /**
     * @var TextProperty
     */
    /**
     * @var TextProperty
     */
    public $title, $caption;
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
    public $csimarea = '', $csimtarget = '', $csimwintarget = '', $csimalt = '';
    /**
     * @var array
     */
    public $constraints = array();
    /**
     * @var int
     */
    public $iCaptionMargin = 5;
    /**
     * @var array
     */
    public $iConstrainPos = array();
    /**
     * @var string
     */
    protected $iStart = "";    // Start date
    /**
     * @var int
     */
    public $iVPos = 0;     // Vertical position
    /**
     * @var int
     */
    protected $iLabelLeftMargin = 2; // Title margin

    /**
     * GanttPlotObject constructor.
     */
    public function __construct()
    {
        $this->title = new TextProperty();
        $this->title->Align('left', 'center');
        $this->caption = new TextProperty();
    }

    /**
     * @return string
     */
    public function GetCSIMArea()
    {
        return $this->csimarea;
    }

    /**
     * @param $aTarget
     * @param string $aAlt
     * @param string $aWinTarget
     * @throws JpGraphExceptionL
     */
    public function SetCSIMTarget($aTarget, $aAlt = '', $aWinTarget = '')
    {
        if (!is_string($aTarget)) {
            $tv = substr(var_export($aTarget, true), 0, 40);
            JpGraphError::RaiseL(6024, $tv);
            //('CSIM Target must be specified as a string.'."\nStart of target is:\n$tv");
        }
        if (!is_string($aAlt)) {
            $tv = substr(var_export($aAlt, true), 0, 40);
            JpGraphError::RaiseL(6025, $tv);
            //('CSIM Alt text must be specified as a string.'."\nStart of alt text is:\n$tv");
        }

        $this->csimtarget = $aTarget;
        $this->csimwintarget = $aWinTarget;
        $this->csimalt = $aAlt;
    }

    /**
     * @param $aAlt
     * @throws JpGraphExceptionL
     */
    public function SetCSIMAlt($aAlt)
    {
        if (!is_string($aAlt)) {
            $tv = substr(var_export($aAlt, true), 0, 40);
            JpGraphError::RaiseL(6025, $tv);
            //('CSIM Alt text must be specified as a string.'."\nStart of alt text is:\n$tv");
        }
        $this->csimalt = $aAlt;
    }

    /**
     * @param $aRow
     * @param $aType
     * @param string $aColor
     * @param int $aArrowSize
     * @param int $aArrowType
     */
    public function SetConstrain($aRow, $aType, $aColor = 'black', $aArrowSize = ARROW_S2, $aArrowType = ARROWT_SOLID)
    {
        $this->constraints[] = new GanttConstraint($aRow, $aType, $aColor, $aArrowSize, $aArrowType);
    }

    /**
     * @param $xt
     * @param $yt
     * @param $xb
     * @param $yb
     */
    public function SetConstrainPos($xt, $yt, $xb, $yb)
    {
        $this->iConstrainPos = array($xt, $yt, $xb, $yb);
    }

    /**
     * @return string
     */
    public function GetMinDate()
    {
        return $this->iStart;
    }

    /**
     * @return string
     */
    public function GetMaxDate()
    {
        return $this->iStart;
    }

    /**
     * @param $aMarg
     */
    public function SetCaptionMargin($aMarg)
    {
        $this->iCaptionMargin = $aMarg;
    }

    /**
     * @param $aImg
     * @return int
     */
    public function GetAbsHeight($aImg)
    {
        return 0;
    }

    /**
     * @return int
     */
    public function GetLineNbr()
    {
        return $this->iVPos;
    }

    /**
     * @param $aOff
     */
    public function SetLabelLeftMargin($aOff)
    {
        $this->iLabelLeftMargin = $aOff;
    }

    /**
     * @param $aImg
     * @param $aScale
     * @param $aYPos
     */
    public function StrokeActInfo($aImg, $aScale, $aYPos)
    {
        $cols = array();
        $aScale->actinfo->GetColStart($aImg, $cols, true);
        $this->title->Stroke($aImg, $cols, $aYPos);
    }
}