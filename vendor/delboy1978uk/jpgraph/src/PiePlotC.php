<?php

/**
 * Class PiePlotC
 */
class PiePlotC extends PiePlot
{
    /**
     * @var float
     */
    private $imidsize = 0.5;  // Fraction of total width
    /**
     * @var string
     */
    private $imidcolor = 'white';
    /**
     * @var string|Text
     */
    public $midtitle = '';
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $middlecsimtarget = '', $middlecsimwintarget = '', $middlecsimalt = '';

    /**
     * PiePlotC constructor.
     * @param $data
     * @param string $aCenterTitle
     * @throws JpGraphExceptionL
     */
    public function __construct($data, $aCenterTitle = '')
    {
        parent::__construct($data);
        $this->midtitle = new Text();
        $this->midtitle->ParagraphAlign('center');
    }

    /**
     * @param $aTitle
     * @param string $aColor
     * @param float $aSize
     */
    public function SetMid($aTitle, $aColor = 'white', $aSize = 0.5)
    {
        $this->midtitle->Set($aTitle);

        $this->imidsize = $aSize;
        $this->imidcolor = $aColor;
    }

    /**
     * @param $aTitle
     */
    public function SetMidTitle($aTitle)
    {
        $this->midtitle->Set($aTitle);
    }

    /**
     * @param $aSize
     */
    public function SetMidSize($aSize)
    {
        $this->imidsize = $aSize;
    }

    /**
     * @param $aColor
     */
    public function SetMidColor($aColor)
    {
        $this->imidcolor = $aColor;
    }

    /**
     * @param $aTarget
     * @param string $aAlt
     * @param string $aWinTarget
     */
    public function SetMidCSIM($aTarget, $aAlt = '', $aWinTarget = '')
    {
        $this->middlecsimtarget = $aTarget;
        $this->middlecsimwintarget = $aWinTarget;
        $this->middlecsimalt = $aAlt;
    }

    /**
     * @param $i
     * @param $xc
     * @param $yc
     * @param $radius
     * @param $sa
     * @param $ea
     */
    public function AddSliceToCSIM($i, $xc, $yc, $radius, $sa, $ea)
    {
        //Slice number, ellipse centre (x,y), radius, start angle, end angle
        while ($sa > 2 * M_PI) $sa = $sa - 2 * M_PI;
        while ($ea > 2 * M_PI) $ea = $ea - 2 * M_PI;

        $sa = 2 * M_PI - $sa;
        $ea = 2 * M_PI - $ea;

        // Special case when we have only one slice since then both start and end
        // angle will be == 0
        if (abs($sa - $ea) < 0.0001) {
            $sa = 2 * M_PI;
            $ea = 0;
        }

        // Add inner circle first point
        $xp = floor(($this->imidsize * $radius * cos($ea)) + $xc);
        $yp = floor($yc - ($this->imidsize * $radius * sin($ea)));
        $coords = "$xp, $yp";

        //add coordinates every 0.25 radians
        $a = $ea + 0.25;

        // If we cross the 360-limit with a slice we need to handle
        // the fact that end angle is smaller than start
        if ($sa < $ea) {
            while ($a <= 2 * M_PI) {
                $xp = floor($radius * cos($a) + $xc);
                $yp = floor($yc - $radius * sin($a));
                $coords .= ", $xp, $yp";
                $a += 0.25;
            }
            $a -= 2 * M_PI;
        }

        while ($a < $sa) {
            $xp = floor(($this->imidsize * $radius * cos($a) + $xc));
            $yp = floor($yc - ($this->imidsize * $radius * sin($a)));
            $coords .= ", $xp, $yp";
            $a += 0.25;
        }

        // Make sure we end at the last point
        $xp = floor(($this->imidsize * $radius * cos($sa) + $xc));
        $yp = floor($yc - ($this->imidsize * $radius * sin($sa)));
        $coords .= ", $xp, $yp";

        // Straight line to outer circle
        $xp = floor($radius * cos($sa) + $xc);
        $yp = floor($yc - $radius * sin($sa));
        $coords .= ", $xp, $yp";

        //add coordinates every 0.25 radians
        $a = $sa - 0.25;
        while ($a > $ea) {
            $xp = floor($radius * cos($a) + $xc);
            $yp = floor($yc - $radius * sin($a));
            $coords .= ", $xp, $yp";
            $a -= 0.25;
        }

        //Add the last point on the arc
        $xp = floor($radius * cos($ea) + $xc);
        $yp = floor($yc - $radius * sin($ea));
        $coords .= ", $xp, $yp";

        // Close the arc
        $xp = floor(($this->imidsize * $radius * cos($ea)) + $xc);
        $yp = floor($yc - ($this->imidsize * $radius * sin($ea)));
        $coords .= ", $xp, $yp";

        if (!empty($this->csimtargets[$i])) {
            $this->csimareas .= "<area shape=\"poly\" coords=\"$coords\" href=\"" .
                $this->csimtargets[$i] . "\"";
            if (!empty($this->csimwintargets[$i])) {
                $this->csimareas .= " target=\"" . $this->csimwintargets[$i] . "\" ";
            }
            if (!empty($this->csimalts[$i])) {
                $tmp = sprintf($this->csimalts[$i], $this->data[$i]);
                $this->csimareas .= " title=\"$tmp\"  alt=\"$tmp\" ";
            }
            $this->csimareas .= " />\n";
        }
    }


    /**
     * @param $img
     * @param int $aaoption
     */
    public function Stroke($img, $aaoption = 0)
    {

        // Stroke the pie but don't stroke values
        $tmp = $this->value->show;
        $this->value->show = false;
        parent::Stroke($img, $aaoption);
        $this->value->show = $tmp;

        $xc = round($this->posx * $img->width);
        $yc = round($this->posy * $img->height);

        $radius = floor($this->radius * min($img->width, $img->height));


        if ($this->imidsize > 0 && $aaoption !== 2) {

            if ($this->ishadowcolor != "") {
                $img->SetColor($this->ishadowcolor);
                $img->FilledCircle($xc + $this->ishadowdrop, $yc + $this->ishadowdrop,
                    round($radius * $this->imidsize));
            }

            $img->SetColor($this->imidcolor);
            $img->FilledCircle($xc, $yc, round($radius * $this->imidsize));

            if ($this->pie_border && $aaoption === 0) {
                $img->SetColor($this->color);
                $img->Circle($xc, $yc, round($radius * $this->imidsize));
            }

            if (!empty($this->middlecsimtarget))
                $this->AddMiddleCSIM($xc, $yc, round($radius * $this->imidsize));

        }

        if ($this->value->show && $aaoption !== 1) {
            $this->StrokeAllLabels($img, $xc, $yc, $radius);
            $this->midtitle->SetPos($xc, $yc, 'center', 'center');
            $this->midtitle->Stroke($img);
        }

    }

    /**
     * @param $xc
     * @param $yc
     * @param $r
     */
    public function AddMiddleCSIM($xc, $yc, $r)
    {
        $xc = round($xc);
        $yc = round($yc);
        $r = round($r);
        $this->csimareas .= "<area shape=\"circle\" coords=\"$xc,$yc,$r\" href=\"" .
            $this->middlecsimtarget . "\"";
        if (!empty($this->middlecsimwintarget)) {
            $this->csimareas .= " target=\"" . $this->middlecsimwintarget . "\"";
        }
        if (!empty($this->middlecsimalt)) {
            $tmp = $this->middlecsimalt;
            $this->csimareas .= " title=\"$tmp\" alt=\"$tmp\" ";
        }
        $this->csimareas .= " />\n";
    }

    /**
     * @param $label
     * @param $img
     * @param $xc
     * @param $yc
     * @param $a
     * @param $r
     */
    public function StrokeLabel($label, $img, $xc, $yc, $a, $r)
    {

        if ($this->ilabelposadj === 'auto')
            $this->ilabelposadj = (1 - $this->imidsize) / 2 + $this->imidsize;

        parent::StrokeLabel($label, $img, $xc, $yc, $a, $r);

    }

}

