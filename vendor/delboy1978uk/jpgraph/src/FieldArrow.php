<?php

/**
 * Class FieldArrow
 */
class FieldArrow
{
    /**
     * @var string
     */
    public $iColor = 'black';
    /**
     * @var int
     */
    public $iSize = 10;  // Length in pixels for  arrow
    /**
     * @var int
     */
    public $iArrowSize = 2;
    /**
     * @var array
     */
    private $isizespec = array(
        array(2, 1), array(3, 2), array(4, 3), array(6, 4), array(7, 4), array(8, 5), array(10, 6), array(12, 7), array(16, 8), array(20, 10)
    );

    /**
     * FieldArrow constructor.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * @param $aSize
     * @param int $aArrowSize
     */
    public function SetSize($aSize, $aArrowSize = 2)
    {
        $this->iSize = $aSize;
        $this->iArrowSize = $aArrowSize;
    }

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    /**
     * @param $aImg
     * @param $x
     * @param $y
     * @param $a
     */
    public function Stroke($aImg, $x, $y, $a)
    {
        // First rotate the center coordinates
        list($x, $y) = $aImg->Rotate($x, $y);

        $old_origin = $aImg->SetCenter($x, $y);
        $old_a = $aImg->a;
        $aImg->SetAngle(-$a + $old_a);

        $dx = round($this->iSize / 2);
        $c = array($x - $dx, $y, $x + $dx, $y);
        $x += $dx;

        list($dx, $dy) = $this->isizespec[$this->iArrowSize];
        $ca = array($x, $y, $x - $dx, $y - $dy, $x - $dx, $y + $dy, $x, $y);

        $aImg->SetColor($this->iColor);
        $aImg->Polygon($c);
        $aImg->FilledPolygon($ca);

        $aImg->SetCenter($old_origin[0], $old_origin[1]);
        $aImg->SetAngle($old_a);
    }
}