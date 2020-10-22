<?php

/**
 * Class LineErrorPlot
 */
class LineErrorPlot extends ErrorPlot
{
    /**
     * @var LinePlot|null
     */
    public $line = null;
    //---------------
    // CONSTRUCTOR
    // Data is (val, errdeltamin, errdeltamax)
    /**
     * LineErrorPlot constructor.
     * @param $datay
     * @param bool $datax
     * @throws JpGraphExceptionL
     */
    public function __construct($datay, $datax = false)
    {
        $ly = array();
        $ey = array();
        $n = count($datay);
        if ($n % 3 != 0) {
            JpGraphError::RaiseL(4002);
            //('Error in input data to LineErrorPlot. Number of data points must be a multiple of 3');
        }
        for ($i = 0; $i < $n; $i += 3) {
            $ly[] = $datay[$i];
            $ey[] = $datay[$i] + $datay[$i + 1];
            $ey[] = $datay[$i] + $datay[$i + 2];
        }
        parent::__construct($ey, $datax);
        $this->line = new LinePlot($ly, $datax);
    }

    //---------------
    // PUBLIC METHODS
    /**
     * @param $graph
     */
    public function Legend($graph)
    {
        if ($this->legend != "")
            $graph->legend->Add($this->legend, $this->color);
        $this->line->Legend($graph);
    }

    /**
     * @param $img
     * @param $xscale
     * @param $yscale
     * @return bool|void
     * @throws JpGraphExceptionL
     */
    public function Stroke($img, $xscale, $yscale)
    {
        parent::Stroke($img, $xscale, $yscale);
        $this->line->Stroke($img, $xscale, $yscale);
    }
}