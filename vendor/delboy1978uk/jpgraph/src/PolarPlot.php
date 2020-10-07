<?php

/**
 * Class PolarPlot
 */
class PolarPlot
{
    /**
     * @var string
     */
    /**
     * @var PlotMark|string
     */
    public $line_style = 'solid', $mark;
    /**
     * @var string
     */
    public $legendcsimtarget = '';
    /**
     * @var string
     */
    public $legendcsimalt = '';
    /**
     * @var string
     */
    public $legend = "";
    /**
     * @var array
     */
    public $csimtargets = array(); // Array of targets for CSIM
    /**
     * @var string
     */
    public $csimareas = "";   // Resultant CSIM area tags
    /**
     * @var null
     */
    public $csimalts = null;   // ALT:s for corresponding target
    /**
     * @var null
     */
    public $scale = null;
    /**
     * @var float|int
     */
    private $numpoints = 0;
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $iColor = 'navy', $iFillColor = '';
    /**
     * @var int
     */
    private $iLineWeight = 1;
    /**
     * @var null
     */
    private $coord = null;

    /**
     * PolarPlot constructor.
     * @param $aData
     * @throws JpGraphExceptionL
     */
    public function __construct($aData)
    {
        $n = count($aData);
        if ($n & 1) {
            JpGraphError::RaiseL(17001);
            //('Polar plots must have an even number of data point. Each data point is a tuple (angle,radius).');
        }
        $this->numpoints = $n / 2;
        $this->coord = $aData;
        $this->mark = new PlotMark();
    }

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->iLineWeight = $aWeight;
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
    public function SetFillColor($aColor)
    {
        $this->iFillColor = $aColor;
    }

    /**
     * @return mixed
     */
    public function Max()
    {
        $m = $this->coord[1];
        $i = 1;
        while ($i < $this->numpoints) {
            $m = max($m, $this->coord[2 * $i + 1]);
            ++$i;
        }
        return $m;
    }

    // Set href targets for CSIM

    /**
     * @param $aTargets
     * @param null $aAlts
     */
    public function SetCSIMTargets($aTargets, $aAlts = null)
    {
        $this->csimtargets = $aTargets;
        $this->csimalts = $aAlts;
    }

    // Get all created areas

    /**
     * @return string
     */
    public function GetCSIMareas()
    {
        return $this->csimareas;
    }

    /**
     * @param $aLegend
     * @param string $aCSIM
     * @param string $aCSIMAlt
     */
    public function SetLegend($aLegend, $aCSIM = "", $aCSIMAlt = "")
    {
        $this->legend = $aLegend;
        $this->legendcsimtarget = $aCSIM;
        $this->legendcsimalt = $aCSIMAlt;
    }

    // Private methods

    /**
     * @param $aGraph
     */
    public function Legend($aGraph)
    {
        $color = $this->iColor;
        if ($this->legend != "") {
            if ($this->iFillColor != '') {
                $color = $this->iFillColor;
                $aGraph->legend->Add($this->legend, $color, $this->mark, 0,
                    $this->legendcsimtarget, $this->legendcsimalt);
            } else {
                $aGraph->legend->Add($this->legend, $color, $this->mark, $this->line_style,
                    $this->legendcsimtarget, $this->legendcsimalt);
            }
        }
    }

    /**
     * @param $img
     * @param $scale
     * @throws JpGraphExceptionL
     */
    public function Stroke($img, $scale)
    {

        $i = 0;
        $p = array();
        $this->csimareas = '';
        while ($i < $this->numpoints) {
            list($x1, $y1) = $scale->PTranslate($this->coord[2 * $i], $this->coord[2 * $i + 1]);
            $p[2 * $i] = $x1;
            $p[2 * $i + 1] = $y1;

            if (isset($this->csimtargets[$i])) {
                $this->mark->SetCSIMTarget($this->csimtargets[$i]);
                $this->mark->SetCSIMAlt($this->csimalts[$i]);
                $this->mark->SetCSIMAltVal($this->coord[2 * $i], $this->coord[2 * $i + 1]);
                $this->mark->Stroke($img, $x1, $y1);
                $this->csimareas .= $this->mark->GetCSIMAreas();
            } else {
                $this->mark->Stroke($img, $x1, $y1);
            }

            ++$i;
        }

        if ($this->iFillColor != '') {
            $img->SetColor($this->iFillColor);
            $img->FilledPolygon($p);
        }
        $img->SetLineWeight($this->iLineWeight);
        $img->SetColor($this->iColor);
        $img->Polygon($p, $this->iFillColor != '');
    }
}