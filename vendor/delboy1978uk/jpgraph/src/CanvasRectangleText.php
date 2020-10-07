<?php

/**
 * Class CanvasRectangleText
 */
class CanvasRectangleText
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
    /**
     * @var int
     */
    /**
     * @var int
     */
    private $ix, $iy, $iw, $ih, $ir = 4;
    /**
     * @var Text
     */
    /**
     * @var Text
     */
    /**
     * @var Text
     */
    /**
     * @var Text
     */
    private $iTxt, $iColor = 'black', $iFillColor = '', $iFontColor = 'black';
    /**
     * @var string
     */
    private $iParaAlign = 'center';
    /**
     * @var int
     */
    private $iAutoBoxMargin = 5;
    /**
     * @var int
     */
    /**
     * @var int
     */
    private $iShadowWidth = 3, $iShadowColor = '';

    /**
     * CanvasRectangleText constructor.
     * @param string $aTxt
     * @param int $xl
     * @param int $yt
     * @param int $w
     * @param int $h
     * @throws JpGraphExceptionL
     */
    public function __construct($aTxt = '', $xl = 0, $yt = 0, $w = 0, $h = 0)
    {
        $this->iTxt = new Text($aTxt);
        $this->ix = $xl;
        $this->iy = $yt;
        $this->iw = $w;
        $this->ih = $h;
    }

    /**
     * @param string $aColor
     * @param int $aWidth
     */
    public function SetShadow($aColor = 'gray', $aWidth = 3)
    {
        $this->iShadowColor = $aColor;
        $this->iShadowWidth = $aWidth;
    }

    /**
     * @param $FontFam
     * @param $aFontStyle
     * @param int $aFontSize
     */
    public function SetFont($FontFam, $aFontStyle, $aFontSize = 12)
    {
        $this->iTxt->SetFont($FontFam, $aFontStyle, $aFontSize);
    }

    /**
     * @param $aTxt
     */
    public function SetTxt($aTxt)
    {
        $this->iTxt->Set($aTxt);
    }

    /**
     * @param $aParaAlign
     */
    public function ParagraphAlign($aParaAlign)
    {
        $this->iParaAlign = $aParaAlign;
    }

    /**
     * @param $aFillColor
     */
    public function SetFillColor($aFillColor)
    {
        $this->iFillColor = $aFillColor;
    }

    /**
     * @param $aMargin
     */
    public function SetAutoMargin($aMargin)
    {
        $this->iAutoBoxMargin = $aMargin;
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
    public function SetFontColor($aColor)
    {
        $this->iFontColor = $aColor;
    }

    /**
     * @param int $xl
     * @param int $yt
     * @param int $w
     * @param int $h
     */
    public function SetPos($xl = 0, $yt = 0, $w = 0, $h = 0)
    {
        $this->ix = $xl;
        $this->iy = $yt;
        $this->iw = $w;
        $this->ih = $h;
    }

    /**
     * @param int $xl
     * @param int $yt
     * @param int $w
     * @param int $h
     */
    public function Pos($xl = 0, $yt = 0, $w = 0, $h = 0)
    {
        $this->ix = $xl;
        $this->iy = $yt;
        $this->iw = $w;
        $this->ih = $h;
    }

    /**
     * @param $aTxt
     * @param $xl
     * @param $yt
     * @param int $w
     * @param int $h
     */
    public function Set($aTxt, $xl, $yt, $w = 0, $h = 0)
    {
        $this->iTxt->Set($aTxt);
        $this->ix = $xl;
        $this->iy = $yt;
        $this->iw = $w;
        $this->ih = $h;
    }

    /**
     * @param int $aRad
     */
    public function SetCornerRadius($aRad = 5)
    {
        $this->ir = $aRad;
    }

    /**
     * @param $aImg
     * @param $scale
     * @return array
     */
    public function Stroke($aImg, $scale)
    {

        // If coordinates are specifed as negative this means we should
        // treat them as abolsute (pixels) coordinates
        if ($this->ix > 0) {
            $this->ix = $scale->TranslateX($this->ix);
        } else {
            $this->ix = -$this->ix;
        }

        if ($this->iy > 0) {
            $this->iy = $scale->TranslateY($this->iy);
        } else {
            $this->iy = -$this->iy;
        }

        list($this->iw, $this->ih) = $scale->Translate($this->iw, $this->ih);

        if ($this->iw == 0)
            $this->iw = round($this->iTxt->GetWidth($aImg) + $this->iAutoBoxMargin);
        if ($this->ih == 0) {
            $this->ih = round($this->iTxt->GetTextHeight($aImg) + $this->iAutoBoxMargin);
        }

        if ($this->iShadowColor != '') {
            $aImg->PushColor($this->iShadowColor);
            $aImg->FilledRoundedRectangle($this->ix + $this->iShadowWidth,
                $this->iy + $this->iShadowWidth,
                $this->ix + $this->iw - 1 + $this->iShadowWidth,
                $this->iy + $this->ih - 1 + $this->iShadowWidth,
                $this->ir);
            $aImg->PopColor();
        }

        if ($this->iFillColor != '') {
            $aImg->PushColor($this->iFillColor);
            $aImg->FilledRoundedRectangle($this->ix, $this->iy,
                $this->ix + $this->iw - 1,
                $this->iy + $this->ih - 1,
                $this->ir);
            $aImg->PopColor();
        }

        if ($this->iColor != '') {
            $aImg->PushColor($this->iColor);
            $aImg->RoundedRectangle($this->ix, $this->iy,
                $this->ix + $this->iw - 1,
                $this->iy + $this->ih - 1,
                $this->ir);
            $aImg->PopColor();
        }

        $this->iTxt->Align('center', 'center');
        $this->iTxt->ParagraphAlign($this->iParaAlign);
        $this->iTxt->SetColor($this->iFontColor);
        $this->iTxt->Stroke($aImg, $this->ix + $this->iw / 2, $this->iy + $this->ih / 2);

        return array($this->iw, $this->ih);

    }

}