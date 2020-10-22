<?php

/**
 * Class BoxPlot
 */
class BoxPlot extends StockPlot
{
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $iPColor = 'black', $iNColor = 'white';

    /**
     * BoxPlot constructor.
     * @param $datay
     * @param bool $datax
     * @throws JpGraphExceptionL
     */
    public function __construct($datay, $datax = false)
    {
        $this->iTupleSize = 5;
        parent::__construct($datay, $datax);
    }

    /**
     * @param $aPos
     * @param $aNeg
     */
    public function SetMedianColor($aPos, $aNeg)
    {
        $this->iPColor = $aPos;
        $this->iNColor = $aNeg;
    }

    /**
     * @param $img
     * @param $xscale
     * @param $yscale
     * @param $i
     * @param $xl
     * @param $xr
     * @param $neg
     */
    public function ModBox($img, $xscale, $yscale, $i, $xl, $xr, $neg)
    {
        if ($neg)
            $img->SetColor($this->iNColor);
        else
            $img->SetColor($this->iPColor);

        $y = $yscale->Translate($this->coords[0][$i * 5 + 4]);
        $img->Line($xl, $y, $xr, $y);
    }
}