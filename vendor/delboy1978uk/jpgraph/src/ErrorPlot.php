<?php

/**
 * Class ErrorPlot
 */
class ErrorPlot extends Plot
{
    /**
     * @var int
     */
    private $errwidth = 2;

    //---------------
    // CONSTRUCTOR
    /**
     * ErrorPlot constructor.
     * @param $datay
     * @param bool $datax
     * @throws JpGraphExceptionL
     */
    public function __construct($datay, $datax = false)
    {
        parent::__construct($datay, $datax);
        $this->numpoints /= 2;
    }
    //---------------
    // PUBLIC METHODS

    // Gets called before any axis are stroked
    /**
     * @param $graph
     * @return bool|void
     */
    public function PreStrokeAdjust($graph)
    {
        if ($this->center) {
            $a = 0.5;
            $b = 0.5;
            ++$this->numpoints;
        } else {
            $a = 0;
            $b = 0;
        }
        $graph->xaxis->scale->ticks->SetXLabelOffset($a);
        $graph->SetTextScaleOff($b);
        //$graph->xaxis->scale->ticks->SupressMinorTickMarks();
    }

    // Method description

    /**
     * @param $img
     * @param $xscale
     * @param $yscale
     * @return bool|void
     * @throws JpGraphExceptionL
     */
    public function Stroke($img, $xscale, $yscale)
    {
        $numpoints = count($this->coords[0]) / 2;
        $img->SetColor($this->color);
        $img->SetLineWeight($this->weight);

        if (isset($this->coords[1])) {
            if (count($this->coords[1]) != $numpoints)
                JpGraphError::RaiseL(2003, count($this->coords[1]), $numpoints);
            //("Number of X and Y points are not equal. Number of X-points:".count($this->coords[1])." Number of Y-points:$numpoints");
            else
                $exist_x = true;
        } else
            $exist_x = false;

        for ($i = 0; $i < $numpoints; ++$i) {
            if ($exist_x)
                $x = $this->coords[1][$i];
            else
                $x = $i;

            if (!is_numeric($x) ||
                !is_numeric($this->coords[0][$i * 2]) || !is_numeric($this->coords[0][$i * 2 + 1])) {
                continue;
            }

            $xt = $xscale->Translate($x);
            $yt1 = $yscale->Translate($this->coords[0][$i * 2]);
            $yt2 = $yscale->Translate($this->coords[0][$i * 2 + 1]);
            $img->Line($xt, $yt1, $xt, $yt2);
            $img->Line($xt - $this->errwidth, $yt1, $xt + $this->errwidth, $yt1);
            $img->Line($xt - $this->errwidth, $yt2, $xt + $this->errwidth, $yt2);
        }
        return true;
    }
} 


