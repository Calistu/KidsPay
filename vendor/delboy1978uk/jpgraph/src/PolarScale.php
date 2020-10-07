<?php

/**
 * Class PolarScale
 */
class PolarScale extends LinearScale
{
    /**
     * @var
     */
    private $graph;
    /**
     * @var bool
     */
    public $clockwise = false;

    /**
     * PolarScale constructor.
     * @param $aMax
     * @param $graph
     * @param $aClockwise
     */
    public function __construct($aMax, $graph, $aClockwise)
    {
        parent::__construct(0, $aMax, 'x');
        $this->graph = $graph;
        $this->clockwise = $aClockwise;
    }

    /**
     * @param $aFlg
     */
    public function SetClockwise($aFlg)
    {
        $this->clockwise = $aFlg;
    }

    /**
     * @param $v
     * @return float|int
     * @throws JpGraphExceptionL
     */
    public function _Translate($v)
    {
        return parent::Translate($v);
    }

    /**
     * @param $aAngle
     * @param $aRad
     * @return array
     * @throws JpGraphExceptionL
     */
    public function PTranslate($aAngle, $aRad)
    {

        $m = $this->scale[1];
        $w = $this->graph->img->plotwidth / 2;
        $aRad = $aRad / $m * $w;

        $a = $aAngle / 180 * M_PI;
        if ($this->clockwise) {
            $a = 2 * M_PI - $a;
        }

        $x = cos($a) * $aRad;
        $y = sin($a) * $aRad;

        $x += $this->_Translate(0);

        if ($this->graph->iType == POLAR_360) {
            $y = ($this->graph->img->top_margin + $this->graph->img->plotheight / 2) - $y;
        } else {
            $y = ($this->graph->img->top_margin + $this->graph->img->plotheight) - $y;
        }
        return array($x, $y);
    }
}