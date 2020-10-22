<?php


//===================================================
// CLASS Ticks
// Description: Abstract base class for drawing linear and logarithmic
// tick marks on axis
//===================================================

/**
 * Class Ticks
 */
class Ticks
{
    /**
     * @var string
     */
    public $label_formatstr = '';   // C-style format string to use for labels
    /**
     * @var string
     */
    public $label_formfunc = '';
    /**
     * @var string
     */
    public $label_dateformatstr = '';
    /**
     * @var int
     */
    public $direction = 1; // Should ticks be in(=1) the plot area or outside (=-1)
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    public $supress_last = false, $supress_tickmarks = false, $supress_minor_tickmarks = false;
    /**
     * @var array
     */
    /**
     * @var array
     */
    /**
     * @var array
     */
    /**
     * @var array
     */
    public $maj_ticks_pos = array(), $maj_ticklabels_pos = array(),
        $ticks_pos = array(), $maj_ticks_label = array();
    /**
     * @var int
     */
    public $precision;

    /**
     * @var int
     */
    /**
     * @var int
     */
    protected $minor_abs_size = 3, $major_abs_size = 5;
    /**
     * @var
     */
    protected $scale;
    /**
     * @var bool
     */
    protected $is_set = false;
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    protected $supress_zerolabel = false, $supress_first = false;
    /**
     * @var string
     */
    /**
     * @var string
     */
    protected $mincolor = '', $majcolor = '';
    /**
     * @var int
     */
    protected $weight = 1;
    /**
     * @var bool
     */
    protected $label_usedateformat = FALSE;

    /**
     * Ticks constructor.
     * @param $aScale
     */
    public function __construct($aScale)
    {
        $this->scale = $aScale;
        $this->precision = -1;
    }

    // Set format string for automatic labels

    /**
     * @param $aFormatString
     * @param bool $aDate
     */
    public function SetLabelFormat($aFormatString, $aDate = FALSE)
    {
        $this->label_formatstr = $aFormatString;
        $this->label_usedateformat = $aDate;
    }

    /**
     * @param $aFormatString
     */
    public function SetLabelDateFormat($aFormatString)
    {
        $this->label_dateformatstr = $aFormatString;
    }

    /**
     * @param $aCallbackFuncName
     */
    public function SetFormatCallback($aCallbackFuncName)
    {
        $this->label_formfunc = $aCallbackFuncName;
    }

    // Don't display the first zero label

    /**
     * @param bool $aFlag
     */
    public function SupressZeroLabel($aFlag = true)
    {
        $this->supress_zerolabel = $aFlag;
    }

    // Don't display minor tick marks

    /**
     * @param bool $aHide
     */
    public function SupressMinorTickMarks($aHide = true)
    {
        $this->supress_minor_tickmarks = $aHide;
    }

    // Don't display major tick marks

    /**
     * @param bool $aHide
     */
    public function SupressTickMarks($aHide = true)
    {
        $this->supress_tickmarks = $aHide;
    }

    // Hide the first tick mark

    /**
     * @param bool $aHide
     */
    public function SupressFirst($aHide = true)
    {
        $this->supress_first = $aHide;
    }

    // Hide the last tick mark

    /**
     * @param bool $aHide
     */
    public function SupressLast($aHide = true)
    {
        $this->supress_last = $aHide;
    }

    // Size (in pixels) of minor tick marks

    /**
     * @return int
     */
    public function GetMinTickAbsSize()
    {
        return $this->minor_abs_size;
    }

    // Size (in pixels) of major tick marks

    /**
     * @return int
     */
    public function GetMajTickAbsSize()
    {
        return $this->major_abs_size;
    }

    /**
     * @param $aMajSize
     * @param int $aMinSize
     */
    public function SetSize($aMajSize, $aMinSize = 3)
    {
        $this->major_abs_size = $aMajSize;
        $this->minor_abs_size = $aMinSize;
    }

    // Have the ticks been specified

    /**
     * @return bool
     */
    public function IsSpecified()
    {
        return $this->is_set;
    }

    /**
     * @param $aSide
     */
    public function SetSide($aSide)
    {
        $this->direction = $aSide;
    }

    // Which side of the axis should the ticks be on

    /**
     * @param int $aSide
     */
    public function SetDirection($aSide = SIDE_RIGHT)
    {
        $this->direction = $aSide;
    }

    // Set colors for major and minor tick marks

    /**
     * @param $aMajorColor
     * @param string $aMinorColor
     */
    public function SetMarkColor($aMajorColor, $aMinorColor = '')
    {
        $this->SetColor($aMajorColor, $aMinorColor);
    }

    /**
     * @param $aMajorColor
     * @param string $aMinorColor
     */
    public function SetColor($aMajorColor, $aMinorColor = '')
    {
        $this->majcolor = $aMajorColor;

        // If not specified use same as major
        if ($aMinorColor == '') {
            $this->mincolor = $aMajorColor;
        } else {
            $this->mincolor = $aMinorColor;
        }
    }

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

}