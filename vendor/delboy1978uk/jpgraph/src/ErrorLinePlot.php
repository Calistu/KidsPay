<?php

/**
 * Class ErrorLinePlot
 */
class ErrorLinePlot extends ErrorPlot
{
    /**
     * @var LinePlot|null
     */
    public $line = null;
    //---------------
    // CONSTRUCTOR
    /**
     * ErrorLinePlot constructor.
     * @param $datay
     * @param bool $datax
     * @throws JpGraphExceptionL
     */
    public function __construct($datay, $datax = false)
    {
        parent::__construct($datay, $datax);
        // Calculate line coordinates as the average of the error limits
        $n = count($datay);
        for ($i = 0; $i < $n; $i += 2) {
            $ly[] = ($datay[$i] + $datay[$i + 1]) / 2;
        }
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

