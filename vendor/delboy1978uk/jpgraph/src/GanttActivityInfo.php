<?php

/**
 * Class GanttActivityInfo
 */
class GanttActivityInfo
{
    /**
     * @var bool
     */
    public $iShow = true;
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
    public $iLeftColMargin = 4, $iRightColMargin = 1, $iTopColMargin = 1, $iBottomColMargin = 3;
    /**
     * @var LineProperty|null
     */
    public $vgrid = null;
    /**
     * @var string
     */
    private $iColor = 'black';
    /**
     * @var string
     */
    private $iBackgroundColor = 'lightgray';
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
    private $iFFamily = FF_FONT1, $iFStyle = FS_NORMAL, $iFSize = 10, $iFontColor = 'black';
    /**
     * @var array
     */
    private $iTitles = array();
    /**
     * @var array
     */
    /**
     * @var array
     */
    private $iWidth = array(), $iHeight = -1;
    /**
     * @var int
     */
    private $iTopHeaderMargin = 4;
    /**
     * @var int
     */
    private $iStyle = 1;
    /**
     * @var string
     */
    private $iHeaderAlign = 'center';

    /**
     * GanttActivityInfo constructor.
     */
    public function __construct()
    {
        $this->vgrid = new LineProperty();
    }

    /**
     * @param bool $aF
     */
    public function Hide($aF = true)
    {
        $this->iShow = !$aF;
    }

    /**
     * @param bool $aF
     */
    public function Show($aF = true)
    {
        $this->iShow = $aF;
    }

    // Specify font

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
     * @param $aStyle
     */
    public function SetStyle($aStyle)
    {
        $this->iStyle = $aStyle;
    }

    /**
     * @param $aLeft
     * @param $aRight
     */
    public function SetColumnMargin($aLeft, $aRight)
    {
        $this->iLeftColMargin = $aLeft;
        $this->iRightColMargin = $aRight;
    }

    /**
     * @param $aFontColor
     */
    public function SetFontColor($aFontColor)
    {
        $this->iFontColor = $aFontColor;
    }

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    /**
     * @param $aColor
     */
    public function SetBackgroundColor($aColor)
    {
        $this->iBackgroundColor = $aColor;
    }

    /**
     * @param $aTitles
     * @param null $aWidth
     */
    public function SetColTitles($aTitles, $aWidth = null)
    {
        $this->iTitles = $aTitles;
        $this->iWidth = $aWidth;
    }

    /**
     * @param $aWidths
     */
    public function SetMinColWidth($aWidths)
    {
        $n = min(count($this->iTitles), count($aWidths));
        for ($i = 0; $i < $n; ++$i) {
            if (!empty($aWidths[$i])) {
                if (empty($this->iWidth[$i])) {
                    $this->iWidth[$i] = $aWidths[$i];
                } else {
                    $this->iWidth[$i] = max($this->iWidth[$i], $aWidths[$i]);
                }
            }
        }
    }

    /**
     * @param $aImg
     * @return float|int|mixed
     * @throws JpGraphExceptionL
     */
    public function GetWidth($aImg)
    {
        $txt = new TextProperty();
        $txt->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $n = count($this->iTitles);
        $rm = $this->iRightColMargin;
        $w = 0;
        for ($h = 0, $i = 0; $i < $n; ++$i) {
            $w += $this->iLeftColMargin;
            $txt->Set($this->iTitles[$i]);
            if (!empty($this->iWidth[$i])) {
                $w1 = max($txt->GetWidth($aImg) + $rm, $this->iWidth[$i]);
            } else {
                $w1 = $txt->GetWidth($aImg) + $rm;
            }
            $this->iWidth[$i] = $w1;
            $w += $w1;
            $h = max($h, $txt->GetHeight($aImg));
        }
        $this->iHeight = $h + $this->iTopHeaderMargin;
        $txt = '';
        return $w;
    }

    /**
     * @param $aImg
     * @param $aStart
     * @param bool $aAddLeftMargin
     */
    public function GetColStart($aImg, &$aStart, $aAddLeftMargin = false)
    {
        $n = count($this->iTitles);
        $adj = $aAddLeftMargin ? $this->iLeftColMargin : 0;
        $aStart = array($aImg->left_margin + $adj);
        for ($i = 1; $i < $n; ++$i) {
            $aStart[$i] = $aStart[$i - 1] + $this->iLeftColMargin + $this->iWidth[$i - 1];
        }
    }

    // Adjust headers left, right or centered

    /**
     * @param $aAlign
     */
    public function SetHeaderAlign($aAlign)
    {
        $this->iHeaderAlign = $aAlign;
    }

    /**
     * @param $aImg
     * @param $aXLeft
     * @param $aYTop
     * @param $aXRight
     * @param $aYBottom
     * @param bool $aUseTextHeight
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg, $aXLeft, $aYTop, $aXRight, $aYBottom, $aUseTextHeight = false)
    {

        if (!$this->iShow) return;

        $txt = new TextProperty();
        $txt->SetFont($this->iFFamily, $this->iFStyle, $this->iFSize);
        $txt->SetColor($this->iFontColor);
        $txt->SetAlign($this->iHeaderAlign, 'top');
        $n = count($this->iTitles);

        if ($n == 0)
            return;

        $x = $aXLeft;
        $h = $this->iHeight;
        $yTop = $aUseTextHeight ? $aYBottom - $h - $this->iTopColMargin - $this->iBottomColMargin : $aYTop;

        if ($h < 0) {
            JpGraphError::RaiseL(6001);
            //('Internal error. Height for ActivityTitles is < 0');
        }

        $aImg->SetLineWeight(1);
        // Set background color
        $aImg->SetColor($this->iBackgroundColor);
        $aImg->FilledRectangle($aXLeft, $yTop, $aXRight, $aYBottom - 1);

        if ($this->iStyle == 1) {
            // Make a 3D effect
            $aImg->SetColor('white');
            $aImg->Line($aXLeft, $yTop + 1, $aXRight, $yTop + 1);
        }

        for ($i = 0; $i < $n; ++$i) {
            if ($this->iStyle == 1) {
                // Make a 3D effect
                $aImg->SetColor('white');
                $aImg->Line($x + 1, $yTop, $x + 1, $aYBottom);
            }
            $x += $this->iLeftColMargin;
            $txt->Set($this->iTitles[$i]);

            // Adjust the text anchor position according to the choosen alignment
            $xp = $x;
            if ($this->iHeaderAlign == 'center') {
                $xp = (($x - $this->iLeftColMargin) + ($x + $this->iWidth[$i])) / 2;
            } elseif ($this->iHeaderAlign == 'right') {
                $xp = $x + $this->iWidth[$i] - $this->iRightColMargin;
            }

            $txt->Stroke($aImg, $xp, $yTop + $this->iTopHeaderMargin);
            $x += $this->iWidth[$i];
            if ($i < $n - 1) {
                $aImg->SetColor($this->iColor);
                $aImg->Line($x, $yTop, $x, $aYBottom);
            }
        }

        $aImg->SetColor($this->iColor);
        $aImg->Line($aXLeft, $yTop, $aXRight, $yTop);

        // Stroke vertical column dividers
        $cols = array();
        $this->GetColStart($aImg, $cols);
        $n = count($cols);
        for ($i = 1; $i < $n; ++$i) {
            $this->vgrid->Stroke($aImg, $cols[$i], $aYBottom, $cols[$i],
                $aImg->height - $aImg->bottom_margin);
        }
    }
}

