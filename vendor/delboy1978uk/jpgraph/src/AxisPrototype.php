<?php

//===================================================
// CLASS Axis
// Description: Defines X and Y axis. Notes that at the
// moment the code is not really good since the axis on
// several occasion must know wheter it's an X or Y axis.
// This was a design decision to make the code easier to
// follow.
//===================================================

/**
 * Class AxisPrototype
 */
class AxisPrototype
{
    /**
     * @var null
     */
    public $scale = null;
    /**
     * @var null
     */
    public $img = null;
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    public $hide = false, $hide_labels = false;
    /**
     * @var Text|null
     */
    public $title = null;
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $font_family = FF_DEFAULT, $font_style = FS_NORMAL, $font_size = 8, $label_angle = 0;
    /**
     * @var int
     */
    public $tick_step = 1;
    /**
     * @var bool
     */
    public $pos = false;
    /**
     * @var array
     */
    public $ticks_label = array();

    /**
     * @var int
     */
    protected $weight = 1;
    /**
     * @var array
     */
    /**
     * @var array
     */
    protected $color = array(0, 0, 0), $label_color = array(0, 0, 0);
    /**
     * @var null
     */
    protected $ticks_label_colors = null;
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    protected $show_first_label = true, $show_last_label = true;
    /**
     * @var int
     */
    protected $label_step = 1; // Used by a text axis to specify what multiple of major steps
    // should be labeled.
    /**
     * @var int
     */
    protected $labelPos = 0;   // Which side of the axis should the labels be?
    /**
     * @var string
     */
    /**
     * @var int|string
     */
    /**
     * @var int|string
     */
    protected $title_adjust, $title_margin, $title_side = SIDE_LEFT;
    /**
     * @var int
     */
    protected $tick_label_margin = 5;
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    protected $label_halign = '', $label_valign = '', $label_para_align = 'left';
    /**
     * @var bool
     */
    protected $hide_line = false;
    /**
     * @var int
     */
    protected $iDeltaAbsPos = 0;

    /**
     * AxisPrototype constructor.
     * @param $img
     * @param $aScale
     * @param array $color
     */
    public function __construct($img, $aScale, $color = array(0, 0, 0))
    {
        $this->img = $img;
        $this->scale = $aScale;
        $this->color = $color;
        $this->title = new Text('');

        if ($aScale->type == 'y') {
            $this->title_margin = 25;
            $this->title_adjust = 'middle';
            $this->title->SetOrientation(90);
            $this->tick_label_margin = 7;
            $this->labelPos = SIDE_LEFT;
        } else {
            $this->title_margin = 5;
            $this->title_adjust = 'high';
            $this->title->SetOrientation(0);
            $this->tick_label_margin = 5;
            $this->labelPos = SIDE_DOWN;
            $this->title_side = SIDE_DOWN;
        }
    }

    /**
     * @param $aFormStr
     */
    public function SetLabelFormat($aFormStr)
    {
        $this->scale->ticks->SetLabelFormat($aFormStr);
    }

    /**
     * @param $aFormStr
     * @param bool $aDate
     */
    public function SetLabelFormatString($aFormStr, $aDate = false)
    {
        $this->scale->ticks->SetLabelFormat($aFormStr, $aDate);
    }

    /**
     * @param $aFuncName
     */
    public function SetLabelFormatCallback($aFuncName)
    {
        $this->scale->ticks->SetFormatCallback($aFuncName);
    }

    /**
     * @param $aHAlign
     * @param string $aVAlign
     * @param string $aParagraphAlign
     */
    public function SetLabelAlign($aHAlign, $aVAlign = 'top', $aParagraphAlign = 'left')
    {
        $this->label_halign = $aHAlign;
        $this->label_valign = $aVAlign;
        $this->label_para_align = $aParagraphAlign;
    }

    // Don't display the first label

    /**
     * @param bool $aShow
     */
    public function HideFirstTickLabel($aShow = false)
    {
        $this->show_first_label = $aShow;
    }

    /**
     * @param bool $aShow
     */
    public function HideLastTickLabel($aShow = false)
    {
        $this->show_last_label = $aShow;
    }

    // Manually specify the major and (optional) minor tick position and labels

    /**
     * @param $aMajPos
     * @param null $aMinPos
     * @param null $aLabels
     */
    public function SetTickPositions($aMajPos, $aMinPos = NULL, $aLabels = NULL)
    {
        $this->scale->ticks->SetTickPositions($aMajPos, $aMinPos, $aLabels);
    }

    // Manually specify major tick positions and optional labels

    /**
     * @param $aMajPos
     * @param null $aLabels
     */
    public function SetMajTickPositions($aMajPos, $aLabels = NULL)
    {
        $this->scale->ticks->SetTickPositions($aMajPos, NULL, $aLabels);
    }

    // Hide minor or major tick marks

    /**
     * @param bool $aHideMinor
     * @param bool $aHideMajor
     */
    public function HideTicks($aHideMinor = true, $aHideMajor = true)
    {
        $this->scale->ticks->SupressMinorTickMarks($aHideMinor);
        $this->scale->ticks->SupressTickMarks($aHideMajor);
    }

    // Hide zero label

    /**
     * @param bool $aFlag
     */
    public function HideZeroLabel($aFlag = true)
    {
        $this->scale->ticks->SupressZeroLabel();
    }

    /**
     *
     */
    public function HideFirstLastLabel()
    {
        // The two first calls to ticks method will supress
        // automatically generated scale values. However, that
        // will not affect manually specified value, e.g text-scales.
        // therefor we also make a kludge here to supress manually
        // specified scale labels.
        $this->scale->ticks->SupressLast();
        $this->scale->ticks->SupressFirst();
        $this->show_first_label = false;
        $this->show_last_label = false;
    }

    // Hide the axis

    /**
     * @param bool $aHide
     */
    public function Hide($aHide = true)
    {
        $this->hide = $aHide;
    }

    // Hide the actual axis-line, but still print the labels

    /**
     * @param bool $aHide
     */
    public function HideLine($aHide = true)
    {
        $this->hide_line = $aHide;
    }

    /**
     * @param bool $aHide
     */
    public function HideLabels($aHide = true)
    {
        $this->hide_labels = $aHide;
    }

    // Weight of axis

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    // Axis color

    /**
     * @param $aColor
     * @param bool $aLabelColor
     */
    public function SetColor($aColor, $aLabelColor = false)
    {
        $this->color = $aColor;
        if (!$aLabelColor) $this->label_color = $aColor;
        else $this->label_color = $aLabelColor;
    }

    // Title on axis

    /**
     * @param $aTitle
     * @param string $aAdjustAlign
     */
    public function SetTitle($aTitle, $aAdjustAlign = 'high')
    {
        $this->title->Set($aTitle);
        $this->title_adjust = $aAdjustAlign;
    }

    // Specify distance from the axis

    /**
     * @param $aMargin
     */
    public function SetTitleMargin($aMargin)
    {
        $this->title_margin = $aMargin;
    }

    // Which side of the axis should the axis title be?

    /**
     * @param $aSideOfAxis
     */
    public function SetTitleSide($aSideOfAxis)
    {
        $this->title_side = $aSideOfAxis;
    }

    /**
     * @param $aDir
     */
    public function SetTickSide($aDir)
    {
        $this->scale->ticks->SetSide($aDir);
    }

    /**
     * @param $aMajSize
     * @param int $aMinSize
     */
    public function SetTickSize($aMajSize, $aMinSize = 3)
    {
        $this->scale->ticks->SetSize($aMajSize, $aMinSize = 3);
    }

    // Specify text labels for the ticks. One label for each data point

    /**
     * @param $aLabelArray
     * @param null $aLabelColorArray
     */
    public function SetTickLabels($aLabelArray, $aLabelColorArray = null)
    {
        $this->ticks_label = $aLabelArray;
        $this->ticks_label_colors = $aLabelColorArray;
    }

    /**
     * @param $aMargin
     */
    public function SetLabelMargin($aMargin)
    {
        $this->tick_label_margin = $aMargin;
    }

    // Specify that every $step of the ticks should be displayed starting
    // at $start
    /**
     * @param $aStep
     * @param int $aStart
     */
    public function SetTextTickInterval($aStep, $aStart = 0)
    {
        $this->scale->ticks->SetTextLabelStart($aStart);
        $this->tick_step = $aStep;
    }

    // Specify that every $step tick mark should have a label
    // should be displayed starting
    /**
     * @param $aStep
     * @throws JpGraphExceptionL
     */
    public function SetTextLabelInterval($aStep)
    {
        if ($aStep < 1) {
            JpGraphError::RaiseL(25058);//(" Text label interval must be specified >= 1.");
        }
        $this->label_step = $aStep;
    }

    /**
     * @param $aSidePos
     */
    public function SetLabelSide($aSidePos)
    {
        $this->labelPos = $aSidePos;
    }

    // Set the font

    /**
     * @param $aFamily
     * @param int $aStyle
     * @param int $aSize
     */
    public function SetFont($aFamily, $aStyle = FS_NORMAL, $aSize = 10)
    {
        $this->font_family = $aFamily;
        $this->font_style = $aStyle;
        $this->font_size = $aSize;
    }

    // Position for axis line on the "other" scale

    /**
     * @param $aPosOnOtherScale
     */
    public function SetPos($aPosOnOtherScale)
    {
        $this->pos = $aPosOnOtherScale;
    }

    // Set the position of the axis to be X-pixels delta to the right
    // of the max X-position (used to position the multiple Y-axis)
    /**
     * @param $aDelta
     */
    public function SetPosAbsDelta($aDelta)
    {
        $this->iDeltaAbsPos = $aDelta;
    }

    // Specify the angle for the tick labels

    /**
     * @param $aAngle
     */
    public function SetLabelAngle($aAngle)
    {
        $this->label_angle = $aAngle;
    }

}