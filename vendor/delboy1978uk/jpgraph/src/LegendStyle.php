<?php

/**
 * Class LegendStyle
 */
class LegendStyle
{
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iLength = 40, $iMargin = 20, $iBottomMargin = 5;
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iCircleWeight = 2, $iCircleRadius = 18, $iCircleColor = 'black';
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iTxtFontFamily = FF_VERDANA, $iTxtFontStyle = FS_NORMAL, $iTxtFontSize = 8;
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iLblFontFamily = FF_VERDANA, $iLblFontStyle = FS_NORMAL, $iLblFontSize = 8;
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iCircleFontFamily = FF_VERDANA, $iCircleFontStyle = FS_NORMAL, $iCircleFontSize = 8;
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $iLblFontColor = 'black', $iTxtFontColor = 'black', $iCircleFontColor = 'black';
    /**
     * @var bool
     */
    public $iShow = true;
    /**
     * @var string
     */
    public $iFormatString = '%.1f';
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iTxtMargin = 6, $iTxt = '';
    /**
     * @var string
     */
    public $iZCircleTxt = 'Calm';

    /**
     * @param $aFontFamily
     * @param int $aFontStyle
     * @param int $aFontSize
     */
    function SetFont($aFontFamily, $aFontStyle = FS_NORMAL, $aFontSize = 10)
    {
        $this->iLblFontFamily = $aFontFamily;
        $this->iLblFontStyle = $aFontStyle;
        $this->iLblFontSize = $aFontSize;
        $this->iTxtFontFamily = $aFontFamily;
        $this->iTxtFontStyle = $aFontStyle;
        $this->iTxtFontSize = $aFontSize;
        $this->iCircleFontFamily = $aFontFamily;
        $this->iCircleFontStyle = $aFontStyle;
        $this->iCircleFontSize = $aFontSize;
    }

    /**
     * @param $aFontFamily
     * @param int $aFontStyle
     * @param int $aFontSize
     */
    function SetLFont($aFontFamily, $aFontStyle = FS_NORMAL, $aFontSize = 10)
    {
        $this->iLblFontFamily = $aFontFamily;
        $this->iLblFontStyle = $aFontStyle;
        $this->iLblFontSize = $aFontSize;
    }

    /**
     * @param $aFontFamily
     * @param int $aFontStyle
     * @param int $aFontSize
     */
    function SetTFont($aFontFamily, $aFontStyle = FS_NORMAL, $aFontSize = 10)
    {
        $this->iTxtFontFamily = $aFontFamily;
        $this->iTxtFontStyle = $aFontStyle;
        $this->iTxtFontSize = $aFontSize;
    }

    /**
     * @param $aFontFamily
     * @param int $aFontStyle
     * @param int $aFontSize
     */
    function SetCFont($aFontFamily, $aFontStyle = FS_NORMAL, $aFontSize = 10)
    {
        $this->iCircleFontFamily = $aFontFamily;
        $this->iCircleFontStyle = $aFontStyle;
        $this->iCircleFontSize = $aFontSize;
    }


    /**
     * @param $aColor
     */
    function SetFontColor($aColor)
    {
        $this->iTxtFontColor = $aColor;
        $this->iLblFontColor = $aColor;
        $this->iCircleFontColor = $aColor;
    }

    /**
     * @param $aColor
     */
    function SetTFontColor($aColor)
    {
        $this->iTxtFontColor = $aColor;
    }

    /**
     * @param $aColor
     */
    function SetLFontColor($aColor)
    {
        $this->iLblFontColor = $aColor;
    }

    /**
     * @param $aColor
     */
    function SetCFontColor($aColor)
    {
        $this->iCircleFontColor = $aColor;
    }

    /**
     * @param $aWeight
     */
    function SetCircleWeight($aWeight)
    {
        $this->iCircleWeight = $aWeight;
    }

    /**
     * @param $aRadius
     */
    function SetCircleRadius($aRadius)
    {
        $this->iCircleRadius = $aRadius;
    }

    /**
     * @param $aColor
     */
    function SetCircleColor($aColor)
    {
        $this->iCircleColor = $aColor;
    }

    /**
     * @param $aTxt
     */
    function SetCircleText($aTxt)
    {
        $this->iZCircleTxt = $aTxt;
    }

    /**
     * @param $aMarg
     * @param int $aBottomMargin
     */
    function SetMargin($aMarg, $aBottomMargin = 5)
    {
        $this->iMargin = $aMarg;
        $this->iBottomMargin = $aBottomMargin;
    }

    /**
     * @param $aLength
     */
    function SetLength($aLength)
    {
        $this->iLength = $aLength;
    }

    /**
     * @param bool $aFlg
     */
    function Show($aFlg = true)
    {
        $this->iShow = $aFlg;
    }

    /**
     * @param bool $aFlg
     */
    function Hide($aFlg = true)
    {
        $this->iShow = !$aFlg;
    }

    /**
     * @param $aFmt
     */
    function SetFormat($aFmt)
    {
        $this->iFormatString = $aFmt;
    }

    /**
     * @param $aTxt
     */
    function SetText($aTxt)
    {
        $this->iTxt = $aTxt;
    }

}