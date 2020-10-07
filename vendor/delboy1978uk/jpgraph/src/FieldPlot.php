<?php

/**
 * Class FieldPlot
 */
class FieldPlot extends Plot
{
    /**
     * @var FieldArrow|string
     */
    public $arrow = '';
    /**
     * @var array
     */
    private $iAngles = array();
    /**
     * @var string
     */
    private $iCallback = '';

    /**
     * FieldPlot constructor.
     * @param $datay
     * @param $datax
     * @param $angles
     * @throws JpGraphExceptionL
     */
    public function __construct($datay, $datax, $angles)
    {
        if ((count($datax) != count($datay)))
            JpGraphError::RaiseL(20001);//("Fieldplots must have equal number of X and Y points.");
        if ((count($datax) != count($angles)))
            JpGraphError::RaiseL(20002);//("Fieldplots must have an angle specified for each X and Y points.");

        $this->iAngles = $angles;

        parent::__construct($datay, $datax);
        $this->value->SetAlign('center', 'center');
        $this->value->SetMargin(15);

        $this->arrow = new FieldArrow();
    }

    /**
     * @param $aFunc
     */
    public function SetCallback($aFunc)
    {
        $this->iCallback = $aFunc;
    }

    /**
     * @param $img
     * @param $xscale
     * @param $yscale
     */
    public function Stroke($img, $xscale, $yscale)
    {

        // Remeber base color and size
        $bc = $this->arrow->iColor;
        $bs = $this->arrow->iSize;
        $bas = $this->arrow->iArrowSize;

        for ($i = 0; $i < $this->numpoints; ++$i) {
            // Skip null values
            if ($this->coords[0][$i] === "") {
                continue;
            }

            $f = $this->iCallback;
            if ($f != "") {
                list($cc, $cs, $cas) = call_user_func($f, $this->coords[1][$i], $this->coords[0][$i], $this->iAngles[$i]);
                // Fall back on global data if the callback isn't set
                if ($cc == "") {
                    $cc = $bc;
                }
                if ($cs == "") {
                    $cs = $bs;
                }
                if ($cas == "") {
                    $cas = $bas;
                }
                $this->arrow->SetColor($cc);
                $this->arrow->SetSize($cs, $cas);
            }

            $xt = $xscale->Translate($this->coords[1][$i]);
            $yt = $yscale->Translate($this->coords[0][$i]);

            $this->arrow->Stroke($img, $xt, $yt, $this->iAngles[$i]);
            $this->value->Stroke($img, $this->coords[0][$i], $xt, $yt);
        }
    }


    /**
     * @param $aGraph
     */
    public function Legend($aGraph)
    {
        if ($this->legend != "") {
            $aGraph->legend->Add($this->legend, $this->mark->fill_color, $this->mark, 0,
                $this->legendcsimtarget, $this->legendcsimalt, $this->legendcsimwintarget);
        }
    }
}