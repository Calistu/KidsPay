<?php

/**
 * Class HeaderProperty
 */
class HeaderProperty
{
    /**
     * @var LineProperty
     */
    public $grid;
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    public $iShowLabels = true, $iShowGrid = true;
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
    public $iTitleVertMargin = 3, $iFFamily = FF_FONT0, $iFStyle = FS_NORMAL, $iFSize = 8;
    /**
     * @var int
     */
    public $iStyle = 0;
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $iFrameColor = "black", $iFrameWeight = 1;
    /**
     * @var string
     */
    public $iBackgroundColor = "white";
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $iWeekendBackgroundColor = "lightgray", $iSundayTextColor = "red"; // these are only used with day scale
    /**
     * @var string
     */
    public $iTextColor = "black";
    /**
     * @var string
     */
    public $iLabelFormStr = "%d";
    /**
     * @var int
     */
    public $iIntervall = 1;

    //---------------
    // CONSTRUCTOR
    /**
     * HeaderProperty constructor.
     */
    public function __construct()
    {
        $this->grid = new LineProperty();
    }

    //---------------
    // PUBLIC METHODS
    /**
     * @param bool $aShow
     */
    public function Show($aShow = true)
    {
        $this->iShowLabels = $aShow;
    }

    /**
     * @param $aInt
     */
    public function SetIntervall($aInt)
    {
        $this->iIntervall = $aInt;
    }

    /**
     * @param $aInt
     */
    public function SetInterval($aInt)
    {
        $this->iIntervall = $aInt;
    }

    /**
     * @return int
     */
    public function GetIntervall()
    {
        return $this->iIntervall;
    }

    /**
     * @param $aFFamily
     * @param int $aFStyle
     * @param int $aFSize
     */
    public function SetFont($aFFamily, $aFStyle = FS_NORMAL, $aFSize = 10)
    {
        $this->iFFamily = $aFFamily;
        $this->iFStyle = $aFStyle;
        $this->iFSize = $aFSize;
    }

    /**
     * @param $aColor
     */
    public function SetFontColor($aColor)
    {
        $this->iTextColor = $aColor;
    }

    /**
     * @param $aImg
     * @return mixed
     */
    public function GetFontHeight($aImg)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        return $aImg->GetFontHeight();
    }

    /**
     * @param $aImg
     * @return mixed
     */
    public function GetFontWidth($aImg)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        return $aImg->GetFontWidth();
    }

    /**
     * @param $aImg
     * @param $aStr
     * @return mixed
     */
    public function GetStrWidth($aImg, $aStr)
    {
        $aImg->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        return $aImg->GetTextWidth($aStr);
    }

    /**
     * @param $aStyle
     */
    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    /**
     * @param $aColor
     */
    public function SetBackgroundColor($aColor)
    {
        $this->iBackgroundColor = $aColor;
    }

    /**
     * @param $aWeight
     */
    public function SetFrameWeight($aWeight)
    {
        $this->iFrameWeight = $aWeight;
    }

    /**
     * @param $aColor
     */
    public function SetFrameColor($aColor)
    {
        $this->iFrameColor = $aColor;
    }

    // Only used by day scale

    /**
     * @param $aColor
     */
    public function SetWeekendColor($aColor)
    {
        $this->iWeekendBackgroundColor = $aColor;
    }

    // Only used by day scale

    /**
     * @param $aColor
     */
    public function SetSundayFontColor($aColor)
    {
        $this->iSundayTextColor = $aColor;
    }

    /**
     * @param $aMargin
     */
    public function SetTitleVertMargin($aMargin)
    {
        $this->iTitleVertMargin = $aMargin;
    }

    /**
     * @param $aStr
     */
    public function SetLabelFormatString($aStr)
    {
        $this->iLabelFormStr = $aStr;
    }

    /**
     * @param $aStr
     */
    public function SetFormatString($aStr)
    {
        $this->SetLabelFormatString($aStr);
    }


}