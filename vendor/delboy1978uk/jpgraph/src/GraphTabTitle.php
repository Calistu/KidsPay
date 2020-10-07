<?php

//===================================================
// CLASS GraphTabTitle
// Description: Draw "tab" titles on top of graphs
//===================================================

/**
 * Class GraphTabTitle
 */
class GraphTabTitle extends Text
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
    private $corner = 6, $posx = 7, $posy = 4;
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $fillcolor = 'lightyellow', $bordercolor = 'black';
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $align = 'left', $width = TABTITLE_WIDTHFIT;

    /**
     * GraphTabTitle constructor.
     */
    public function __construct()
    {
        $this->t = '';
        $this->font_style = FS_BOLD;
        $this->hide = true;
        $this->color = 'darkred';
    }

    /**
     * @param $aTxtColor
     * @param string $aFillColor
     * @param string $aBorderColor
     */
    public function SetColor($aTxtColor, $aFillColor = 'lightyellow', $aBorderColor = 'black')
    {
        $this->color = $aTxtColor;
        $this->fillcolor = $aFillColor;
        $this->bordercolor = $aBorderColor;
    }

    /**
     * @param $aFillColor
     */
    public function SetFillColor($aFillColor)
    {
        $this->fillcolor = $aFillColor;
    }

    /**
     * @param $aAlign
     */
    public function SetTabAlign($aAlign)
    {
        $this->align = $aAlign;
    }

    /**
     * @param $aWidth
     */
    public function SetWidth($aWidth)
    {
        $this->width = $aWidth;
    }

    /**
     * @param $t
     */
    public function Set($t)
    {
        $this->t = $t;
        $this->hide = false;
    }

    /**
     * @param $aD
     */
    public function SetCorner($aD)
    {
        $this->corner = $aD;
    }

    /**
     * @param $aImg
     * @param null $aDummy1
     * @param null $aDummy2
     */
    public function Stroke($aImg, $aDummy1 = null, $aDummy2 = null)
    {
        if ($this->hide)
            return;
        $this->boxed = false;
        $w = $this->GetWidth($aImg) + 2 * $this->posx;
        $h = $this->GetTextHeight($aImg) + 2 * $this->posy;

        $x = $aImg->left_margin;
        $y = $aImg->top_margin;

        if ($this->width === TABTITLE_WIDTHFIT) {
            if ($this->align == 'left') {
                $p = array($x, $y,
                    $x, $y - $h + $this->corner,
                    $x + $this->corner, $y - $h,
                    $x + $w - $this->corner, $y - $h,
                    $x + $w, $y - $h + $this->corner,
                    $x + $w, $y);
            } elseif ($this->align == 'center') {
                $x += round($aImg->plotwidth / 2) - round($w / 2);
                $p = array($x, $y,
                    $x, $y - $h + $this->corner,
                    $x + $this->corner, $y - $h,
                    $x + $w - $this->corner, $y - $h,
                    $x + $w, $y - $h + $this->corner,
                    $x + $w, $y);
            } else {
                $x += $aImg->plotwidth - $w;
                $p = array($x, $y,
                    $x, $y - $h + $this->corner,
                    $x + $this->corner, $y - $h,
                    $x + $w - $this->corner, $y - $h,
                    $x + $w, $y - $h + $this->corner,
                    $x + $w, $y);
            }
        } else {
            if ($this->width === TABTITLE_WIDTHFULL) {
                $w = $aImg->plotwidth;
            } else {
                $w = $this->width;
            }

            // Make the tab fit the width of the plot area
            $p = array($x, $y,
                $x, $y - $h + $this->corner,
                $x + $this->corner, $y - $h,
                $x + $w - $this->corner, $y - $h,
                $x + $w, $y - $h + $this->corner,
                $x + $w, $y);

        }
        if ($this->halign == 'left') {
            $aImg->SetTextAlign('left', 'bottom');
            $x += $this->posx;
            $y -= $this->posy;
        } elseif ($this->halign == 'center') {
            $aImg->SetTextAlign('center', 'bottom');
            $x += $w / 2;
            $y -= $this->posy;
        } else {
            $aImg->SetTextAlign('right', 'bottom');
            $x += $w - $this->posx;
            $y -= $this->posy;
        }

        $aImg->SetColor($this->fillcolor);
        $aImg->FilledPolygon($p);

        $aImg->SetColor($this->bordercolor);
        $aImg->Polygon($p, true);

        $aImg->SetColor($this->color);
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $aImg->StrokeText($x, $y, $this->t, 0, 'center');
    }

}