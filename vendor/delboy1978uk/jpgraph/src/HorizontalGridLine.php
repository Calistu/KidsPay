<?php

/**
 * Class HorizontalGridLine
 */
class HorizontalGridLine
{
    /**
     * @var null
     */
    private $iGraph = NULL;
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $iRowColor1 = '', $iRowColor2 = '';
    /**
     * @var bool
     */
    private $iShow = false;
    /**
     * @var LineProperty|null
     */
    private $line = null;
    /**
     * @var int
     */
    private $iStart = 0; // 0=from left margin, 1=just along header

    /**
     * HorizontalGridLine constructor.
     */
    public function __construct()
    {
        $this->line = new LineProperty();
        $this->line->SetColor('gray@0.4');
        $this->line->SetStyle('dashed');
    }

    /**
     * @param bool $aShow
     */
    public function Show($aShow = true)
    {
        $this->iShow = $aShow;
    }

    /**
     * @param $aColor1
     * @param string $aColor2
     */
    public function SetRowFillColor($aColor1, $aColor2 = '')
    {
        $this->iRowColor1 = $aColor1;
        $this->iRowColor2 = $aColor2;
    }

    /**
     * @param $aStart
     */
    public function SetStart($aStart)
    {
        $this->iStart = $aStart;
    }

    /**
     * @param $aImg
     * @param $aScale
     */
    public function Stroke($aImg, $aScale)
    {

        if (!$this->iShow) {
            return;
        }


        if ($this->iStart === 0) {
            $xt = $aImg->left_margin - 1;
        } else {
            $xt = round($aScale->TranslateDate($aScale->iStartDate)) + 1;
        }

        $xb = $aImg->width - $aImg->right_margin;

        $yt = round($aScale->TranslateVertPos(0));
        $yb = round($aScale->TranslateVertPos(1));
        $height = $yb - $yt;

        // Loop around for all lines in the chart
        for ($i = 0; $i < $aScale->iVertLines; ++$i) {
            $yb = $yt - $height;
            $this->line->Stroke($aImg, $xt, $yb, $xb, $yb);
            if ($this->iRowColor1 !== '') {
                if ($i % 2 == 0) {
                    $aImg->PushColor($this->iRowColor1);
                    $aImg->FilledRectangle($xt, $yt, $xb, $yb);
                    $aImg->PopColor();
                } elseif ($this->iRowColor2 !== '') {
                    $aImg->PushColor($this->iRowColor2);
                    $aImg->FilledRectangle($xt, $yt, $xb, $yb);
                    $aImg->PopColor();
                }
            }
            $yt = round($aScale->TranslateVertPos($i + 1));
        }
        $yb = $yt - $height;
        $this->line->Stroke($aImg, $xt, $yb, $xb, $yb);
    }
}