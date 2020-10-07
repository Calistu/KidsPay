<?php

/**
 * Class CanvasScale
 */
class CanvasScale
{
    /**
     * @var
     */
    private $g;
    /**
     * @var
     */
    /**
     * @var
     */
    private $w, $h;
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
    private $ixmin = 0, $ixmax = 10, $iymin = 0, $iymax = 10;

    /**
     * CanvasScale constructor.
     * @param $graph
     * @param int $xmin
     * @param int $xmax
     * @param int $ymin
     * @param int $ymax
     */
    public function __construct($graph, $xmin = 0, $xmax = 10, $ymin = 0, $ymax = 10)
    {
        $this->g = $graph;
        $this->w = $graph->img->width;
        $this->h = $graph->img->height;
        $this->ixmin = $xmin;
        $this->ixmax = $xmax;
        $this->iymin = $ymin;
        $this->iymax = $ymax;
    }

    /**
     * @param int $xmin
     * @param int $xmax
     * @param int $ymin
     * @param int $ymax
     */
    public function Set($xmin = 0, $xmax = 10, $ymin = 0, $ymax = 10)
    {
        $this->ixmin = $xmin;
        $this->ixmax = $xmax;
        $this->iymin = $ymin;
        $this->iymax = $ymax;
    }

    /**
     * @return array
     */
    public function Get()
    {
        return array($this->ixmin, $this->ixmax, $this->iymin, $this->iymax);
    }

    /**
     * @param $x
     * @param $y
     * @return array
     */
    public function Translate($x, $y)
    {
        $xp = round(($x - $this->ixmin) / ($this->ixmax - $this->ixmin) * $this->w);
        $yp = round(($y - $this->iymin) / ($this->iymax - $this->iymin) * $this->h);
        return array($xp, $yp);
    }

    /**
     * @param $x
     * @return float
     */
    public function TranslateX($x)
    {
        $xp = round(($x - $this->ixmin) / ($this->ixmax - $this->ixmin) * $this->w);
        return $xp;
    }

    /**
     * @param $y
     * @return float
     */
    public function TranslateY($y)
    {
        $yp = round(($y - $this->iymin) / ($this->iymax - $this->iymin) * $this->h);
        return $yp;
    }

}

