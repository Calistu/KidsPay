<?php

//===================================================
// CLASS Plot
// Description: Abstract base class for all concrete plot classes
//===================================================

/**
 * Class Plot
 */
class Plot
{
    /**
     * @var int
     */
    public $numpoints = 0;
    /**
     * @var DisplayValue
     */
    public $value;
    /**
     * @var string
     */
    public $legend = '';
    /**
     * @var array
     */
    public $coords = array();
    /**
     * @var string
     */
    public $color = 'black';
    /**
     * @var bool
     */
    public $hidelegend = false;
    /**
     * @var int
     */
    public $line_weight = 1;
    /**
     * @var array
     */
    /**
     * @var array
     */
    public $csimtargets = array(), $csimwintargets = array(); // Array of targets for CSIM
    /**
     * @var string
     */
    public $csimareas = '';   // Resultant CSIM area tags
    /**
     * @var null
     */
    public $csimalts = null;   // ALT:s for corresponding target
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $legendcsimtarget = '', $legendcsimwintarget = '';
    /**
     * @var string
     */
    public $legendcsimalt = '';
    /**
     * @var int
     */
    protected $weight = 1;
    /**
     * @var bool
     */
    protected $center = false;

    /**
     * @var array
     */
    protected $inputValues;
    /**
     * @var bool
     */
    protected $isRunningClear = false;

    /**
     * Plot constructor.
     * @param $aDatay
     * @param bool $aDatax
     * @throws JpGraphExceptionL
     */
    public function __construct($aDatay, $aDatax = false)
    {
        $this->numpoints = count($aDatay);
        if ($this->numpoints == 0) {
            JpGraphError::RaiseL(25121);//("Empty input data array specified for plot. Must have at least one data point.");
        }

        if (!$this->isRunningClear) {
            $this->inputValues = array();
            $this->inputValues['aDatay'] = $aDatay;
            $this->inputValues['aDatax'] = $aDatax;
        }

        $this->coords[0] = $aDatay;
        if (is_array($aDatax)) {
            $this->coords[1] = $aDatax;
            $n = count($aDatax);
            for ($i = 0; $i < $n; ++$i) {
                if (!is_numeric($aDatax[$i])) {
                    JpGraphError::RaiseL(25070);
                }
            }
        }
        $this->value = new DisplayValue();
    }

    // Stroke the plot
    // "virtual" function which must be implemented by
    // the subclasses
    /**
     * @param $aImg
     * @param $aXScale
     * @param $aYScale
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg, $aXScale, $aYScale)
    {
        JpGraphError::RaiseL(25122);//("JpGraph: Stroke() must be implemented by concrete subclass to class Plot");
    }

    /**
     * @param bool $f
     */
    public function HideLegend($f = true)
    {
        $this->hidelegend = $f;
    }

    /**
     * @param $graph
     */
    public function DoLegend($graph)
    {
        if (!$this->hidelegend)
            $this->Legend($graph);
    }

    /**
     * @param $img
     * @param $aVal
     * @param $x
     * @param $y
     */
    public function StrokeDataValue($img, $aVal, $x, $y)
    {
        $this->value->Stroke($img, $aVal, $x, $y);
    }

    // Set href targets for CSIM

    /**
     * @param $aTargets
     * @param string $aAlts
     * @param string $aWinTargets
     */
    public function SetCSIMTargets($aTargets, $aAlts = '', $aWinTargets = '')
    {
        $this->csimtargets = $aTargets;
        $this->csimwintargets = $aWinTargets;
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

    // "Virtual" function which gets called before any scale
    // or axis are stroked used to do any plot specific adjustment
    /**
     * @param $aGraph
     * @return bool
     * @throws JpGraphExceptionL
     */
    public function PreStrokeAdjust($aGraph)
    {
        if (substr($aGraph->axtype, 0, 4) == "text" && (isset($this->coords[1]))) {
            JpGraphError::RaiseL(25123);//("JpGraph: You can't use a text X-scale with specified X-coords. Use a \"int\" or \"lin\" scale instead.");
        }
        return true;
    }

    // Virtual function to the the concrete plot class to make any changes to the graph
    // and scale before the stroke process begins
    /**
     * @param $aGraph
     */
    public function PreScaleSetup($aGraph)
    {
        // Empty
    }

    // Get minimum values in plot

    /**
     * @return array
     */
    public function Min()
    {
        if (isset($this->coords[1])) {
            $x = $this->coords[1];
        } else {
            $x = '';
        }
        if ($x != '' && count($x) > 0) {
            $xm = min($x);
        } else {
            $xm = 0;
        }
        $y = $this->coords[0];
        $cnt = count($y);
        if ($cnt > 0) {
            $i = 0;
            while ($i < $cnt && !is_numeric($ym = $y[$i])) {
                $i++;
            }
            while ($i < $cnt) {
                if (is_numeric($y[$i])) {
                    $ym = min($ym, $y[$i]);
                }
                ++$i;
            }
        } else {
            $ym = '';
        }
        return array($xm, $ym);
    }

    // Get maximum value in plot

    /**
     * @return array
     */
    public function Max()
    {
        if (isset($this->coords[1])) {
            $x = $this->coords[1];
        } else {
            $x = '';
        }

        if ($x != '' && count($x) > 0) {
            $xm = max($x);
        } else {
            $xm = $this->numpoints - 1;
        }
        $y = $this->coords[0];
        if (count($y) > 0) {
            $cnt = count($y);
            $i = 0;
            while ($i < $cnt && !is_numeric($ym = $y[$i])) {
                $i++;
            }
            while ($i < $cnt) {
                if (is_numeric($y[$i])) {
                    $ym = max($ym, $y[$i]);
                }
                ++$i;
            }
        } else {
            $ym = '';
        }
        return array($xm, $ym);
    }

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->color = $aColor;
    }

    /**
     * @param $aLegend
     * @param string $aCSIM
     * @param string $aCSIMAlt
     * @param string $aCSIMWinTarget
     */
    public function SetLegend($aLegend, $aCSIM = '', $aCSIMAlt = '', $aCSIMWinTarget = '')
    {
        $this->legend = $aLegend;
        $this->legendcsimtarget = $aCSIM;
        $this->legendcsimwintarget = $aCSIMWinTarget;
        $this->legendcsimalt = $aCSIMAlt;
    }

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    /**
     * @param int $aWeight
     */
    public function SetLineWeight($aWeight = 1)
    {
        $this->line_weight = $aWeight;
    }

    /**
     * @param bool $aCenter
     */
    public function SetCenter($aCenter = true)
    {
        $this->center = $aCenter;
    }

    // This method gets called by Graph class to plot anything that should go
    // into the margin after the margin color has been set.
    /**
     * @param $aImg
     * @return bool
     */
    public function StrokeMargin($aImg)
    {
        return true;
    }

    // Framework function the chance for each plot class to set a legend

    /**
     * @param $aGraph
     */
    public function Legend($aGraph)
    {
        if ($this->legend != '') {
            $aGraph->legend->Add($this->legend, $this->color, '', 0, $this->legendcsimtarget, $this->legendcsimalt, $this->legendcsimwintarget);
        }
    }

    /**
     * @throws JpGraphExceptionL
     */
    public function Clear()
    {
        $this->isRunningClear = true;
        $this->__construct($this->inputValues['aDatay'], $this->inputValues['aDatax']);
        $this->isRunningClear = false;
    }

} 