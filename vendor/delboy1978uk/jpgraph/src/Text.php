<?php

/**
 * Class Text
 */
class Text
{
    /**
     * @var string
     */
    public $t;
    /**
     * @var float|int
     */
    /**
     * @var float|int
     */
    /**
     * @var float|int
     */
    /**
     * @var float|int
     */
    /**
     * @var float|int
     */
    public $x = 0, $y = 0, $halign = "left", $valign = "top", $color = array(0, 0, 0);
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    public $hide = false, $dir = 0;
    /**
     * @var null
     */
    /**
     * @var null
     */
    public $iScalePosY = null, $iScalePosX = null;
    /**
     * @var int
     */
    public $iWordwrap = 0;
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $font_family = FF_DEFAULT, $font_style = FS_NORMAL; // old. FF_FONT1
    /**
     * @var bool
     */
    protected $boxed = false; // Should the text be boxed
    /**
     * @var string
     */
    protected $paragraph_align = "left";
    /**
     * @var int
     */
    /**
     * @var int
     */
    protected $icornerradius = 0, $ishadowwidth = 3;
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    protected $fcolor = 'white', $bcolor = 'black', $shadow = false;
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
    protected $iCSIMarea = '', $iCSIMalt = '', $iCSIMtarget = '', $iCSIMWinTarget = '';
    /**
     * @var int
     */
    private $iBoxType = 1; // Which variant of filled box around text we want


    public $raw_font_size;

    /**
     * Text constructor.
     * @param string $aTxt
     * @param int $aXAbsPos
     * @param int $aYAbsPos
     * @throws JpGraphExceptionL
     */
    public function __construct($aTxt = "", $aXAbsPos = 0, $aYAbsPos = 0)
    {
        if (!is_string($aTxt)) {
            JpGraphError::RaiseL(25050);//('First argument to Text::Text() must be s atring.');
        }
        $this->t = $aTxt;
        $this->x = round($aXAbsPos);
        $this->y = round($aYAbsPos);
        $this->margin = 0;
    }
    //---------------
    // PUBLIC METHODS
    // Set the string in the text object
    /**
     * @param $aTxt
     */
    public function Set($aTxt)
    {
        $this->t = $aTxt;
    }

    // Alias for Pos()

    /**
     * @param int $aXAbsPos
     * @param int $aYAbsPos
     * @param string $aHAlign
     * @param string $aVAlign
     */
    public function SetPos($aXAbsPos = 0, $aYAbsPos = 0, $aHAlign = "left", $aVAlign = "top")
    {
        //$this->Pos($aXAbsPos,$aYAbsPos,$aHAlign,$aVAlign);
        $this->x = $aXAbsPos;
        $this->y = $aYAbsPos;
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;
    }

    /**
     * @param $aX
     * @param $aY
     */
    public function SetScalePos($aX, $aY)
    {
        $this->iScalePosX = $aX;
        $this->iScalePosY = $aY;
    }

    // Specify alignment for the text

    /**
     * @param $aHAlign
     * @param string $aVAlign
     * @param string $aParagraphAlign
     */
    public function Align($aHAlign, $aVAlign = "top", $aParagraphAlign = "")
    {
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;
        if ($aParagraphAlign != "")
            $this->paragraph_align = $aParagraphAlign;
    }

    // Alias

    /**
     * @param $aHAlign
     * @param string $aVAlign
     * @param string $aParagraphAlign
     */
    public function SetAlign($aHAlign, $aVAlign = "top", $aParagraphAlign = "")
    {
        $this->Align($aHAlign, $aVAlign, $aParagraphAlign);
    }

    // Specifies the alignment for a multi line text

    /**
     * @param $aAlign
     */
    public function ParagraphAlign($aAlign)
    {
        $this->paragraph_align = $aAlign;
    }

    // Specifies the alignment for a multi line text

    /**
     * @param $aAlign
     */
    public function SetParagraphAlign($aAlign)
    {
        $this->paragraph_align = $aAlign;
    }

    /**
     * @param string $aShadowColor
     * @param int $aShadowWidth
     */
    public function SetShadow($aShadowColor = 'gray', $aShadowWidth = 3)
    {
        $this->ishadowwidth = $aShadowWidth;
        $this->shadow = $aShadowColor;
        $this->boxed = true;
    }

    /**
     * @param $aCol
     */
    public function SetWordWrap($aCol)
    {
        $this->iWordwrap = $aCol;
    }

    // Specify that the text should be boxed. fcolor=frame color, bcolor=border color,
    // $shadow=drop shadow should be added around the text.
    /**
     * @param array $aFrameColor
     * @param array $aBorderColor
     * @param bool $aShadowColor
     * @param int $aCornerRadius
     * @param int $aShadowWidth
     */
    public function SetBox($aFrameColor = array(255, 255, 255), $aBorderColor = array(0, 0, 0), $aShadowColor = false, $aCornerRadius = 4, $aShadowWidth = 3)
    {
        if ($aFrameColor === false) {
            $this->boxed = false;
        } else {
            $this->boxed = true;
        }
        $this->fcolor = $aFrameColor;
        $this->bcolor = $aBorderColor;
        // For backwards compatibility when shadow was just true or false
        if ($aShadowColor === true) {
            $aShadowColor = 'gray';
        }
        $this->shadow = $aShadowColor;
        $this->icornerradius = $aCornerRadius;
        $this->ishadowwidth = $aShadowWidth;
    }

    /**
     * @param array $aFrameColor
     * @param array $aBorderColor
     * @param bool $aShadowColor
     * @param int $aCornerRadius
     * @param int $aShadowWidth
     */
    public function SetBox2($aFrameColor = array(255, 255, 255), $aBorderColor = array(0, 0, 0), $aShadowColor = false, $aCornerRadius = 4, $aShadowWidth = 3)
    {
        $this->iBoxType = 2;
        $this->SetBox($aFrameColor, $aBorderColor, $aShadowColor, $aCornerRadius, $aShadowWidth);
    }

    // Hide the text

    /**
     * @param bool $aHide
     */
    public function Hide($aHide = true)
    {
        $this->hide = $aHide;
    }

    // This looks ugly since it's not a very orthogonal design
    // but I added this "inverse" of Hide() to harmonize
    // with some classes which I designed more recently (especially)
    // jpgraph_gantt
    /**
     * @param bool $aShow
     */
    public function Show($aShow = true)
    {
        $this->hide = !$aShow;
    }

    // Specify font

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

    // Center the text between $left and $right coordinates

    /**
     * @param $aLeft
     * @param $aRight
     * @param bool $aYAbsPos
     */
    public function Center($aLeft, $aRight, $aYAbsPos = false)
    {
        $this->x = $aLeft + ($aRight - $aLeft) / 2;
        $this->halign = "center";
        if (is_numeric($aYAbsPos))
            $this->y = $aYAbsPos;
    }

    // Set text color

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->color = $aColor;
    }

    /**
     * @param $aAngle
     */
    public function SetAngle($aAngle)
    {
        $this->SetOrientation($aAngle);
    }

    // Orientation of text. Note only TTF fonts can have an arbitrary angle

    /**
     * @param int $aDirection
     * @throws JpGraphExceptionL
     */
    public function SetOrientation($aDirection = 0)
    {
        if (is_numeric($aDirection))
            $this->dir = $aDirection;
        elseif ($aDirection == "h")
            $this->dir = 0;
        elseif ($aDirection == "v")
            $this->dir = 90;
        else
            JpGraphError::RaiseL(25051);//(" Invalid direction specified for text.");
    }

    // Total width of text

    /**
     * @param $aImg
     * @return mixed
     */
    public function GetWidth($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);
        $w = $aImg->GetTextWidth($this->t, $this->dir);
        return $w;
    }

    // Hight of font

    /**
     * @param $aImg
     * @return mixed
     */
    public function GetFontHeight($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);
        $h = $aImg->GetFontHeight();
        return $h;

    }

    /**
     * @param $aImg
     * @return mixed
     */
    public function GetTextHeight($aImg)
    {
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);
        $h = $aImg->GetTextHeight($this->t, $this->dir);
        return $h;
    }

    /**
     * @param $aImg
     * @return mixed
     */
    public function GetHeight($aImg)
    {
        // Synonym for GetTextHeight()
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);
        $h = $aImg->GetTextHeight($this->t, $this->dir);
        return $h;
    }

    // Set the margin which will be interpretated differently depending
    // on the context.
    /**
     * @param $aMarg
     */
    public function SetMargin($aMarg)
    {
        $this->margin = $aMarg;
    }

    /**
     * @param $aImg
     * @param $axscale
     * @param $ayscale
     */
    public function StrokeWithScale($aImg, $axscale, $ayscale)
    {
        if ($this->iScalePosX === null || $this->iScalePosY === null) {
            $this->Stroke($aImg);
        } else {
            $this->Stroke($aImg,
                round($axscale->Translate($this->iScalePosX)),
                round($ayscale->Translate($this->iScalePosY)));
        }
    }

    /**
     * @param $aURITarget
     * @param string $aAlt
     * @param string $aWinTarget
     */
    public function SetCSIMTarget($aURITarget, $aAlt = '', $aWinTarget = '')
    {
        $this->iCSIMtarget = $aURITarget;
        $this->iCSIMalt = $aAlt;
        $this->iCSIMWinTarget = $aWinTarget;
    }

    /**
     * @return string
     */
    public function GetCSIMareas()
    {
        if ($this->iCSIMtarget !== '') {
            return $this->iCSIMarea;
        } else {
            return '';
        }
    }

    // Display text in image

    /**
     * @param $aImg
     * @param null $x
     * @param null $y
     */
    public function Stroke($aImg, $x = null, $y = null)
    {

        if ($x !== null) $this->x = round($x);
        if ($y !== null) $this->y = round($y);

        // Insert newlines
        if ($this->iWordwrap > 0) {
            $this->t = wordwrap($this->t, $this->iWordwrap, "\n");
        }

        // If position been given as a fraction of the image size
        // calculate the absolute position
        if ($this->x < 1 && $this->x > 0) $this->x *= $aImg->width;
        if ($this->y < 1 && $this->y > 0) $this->y *= $aImg->height;

        $aImg->PushColor($this->color);
        $aImg->SetFont($this->font_family, $this->font_style, $this->raw_font_size);
        $aImg->SetTextAlign($this->halign, $this->valign);

        if ($this->boxed) {
            if ($this->fcolor == "nofill") {
                $this->fcolor = false;
            }

            $oldweight = $aImg->SetLineWeight(1);

            if ($this->iBoxType == 2 && $this->font_family > FF_FONT2 + 2) {

                $bbox = $aImg->StrokeBoxedText2($this->x, $this->y,
                    $this->t, $this->dir,
                    $this->fcolor,
                    $this->bcolor,
                    $this->shadow,
                    $this->paragraph_align,
                    2, 4,
                    $this->icornerradius,
                    $this->ishadowwidth);
            } else {
                $bbox = $aImg->StrokeBoxedText($this->x, $this->y, $this->t,
                    $this->dir, $this->fcolor, $this->bcolor, $this->shadow,
                    $this->paragraph_align, 3, 3, $this->icornerradius,
                    $this->ishadowwidth);
            }

            $aImg->SetLineWeight($oldweight);
        } else {
            $debug = false;
            $bbox = $aImg->StrokeText($this->x, $this->y, $this->t, $this->dir, $this->paragraph_align, $debug);
        }

        // Create CSIM targets
        $coords = $bbox[0] . ',' . $bbox[1] . ',' . $bbox[2] . ',' . $bbox[3] . ',' . $bbox[4] . ',' . $bbox[5] . ',' . $bbox[6] . ',' . $bbox[7];
        $this->iCSIMarea = "<area shape=\"poly\" coords=\"$coords\" href=\"" . htmlentities($this->iCSIMtarget) . "\" ";
        if (trim($this->iCSIMalt) != '') {
            $this->iCSIMarea .= " alt=\"" . $this->iCSIMalt . "\" ";
            $this->iCSIMarea .= " title=\"" . $this->iCSIMalt . "\" ";
        }
        if (trim($this->iCSIMWinTarget) != '') {
            $this->iCSIMarea .= " target=\"" . $this->iCSIMWinTarget . "\" ";
        }
        $this->iCSIMarea .= " />\n";

        $aImg->PopColor($this->color);
    }
}

