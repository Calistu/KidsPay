<?php

/**
 * Class LinkArrow
 */
class LinkArrow
{
    /**
     * @var
     */
    /**
     * @var
     */
    private $ix, $iy;
    /**
     * @var array
     */
    private $isizespec = array(
        array(2, 3), array(3, 5), array(3, 8), array(6, 15), array(8, 22));
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    private $iDirection = ARROW_DOWN, $iType = ARROWT_SOLID, $iSize = ARROW_S2;
    /**
     * @var string
     */
    private $iColor = 'black';

    /**
     * LinkArrow constructor.
     * @param $x
     * @param $y
     * @param $aDirection
     * @param int $aType
     * @param int $aSize
     */
    public function __construct($x, $y, $aDirection, $aType = ARROWT_SOLID, $aSize = ARROW_S2)
    {
        $this->iDirection = $aDirection;
        $this->iType = $aType;
        $this->iSize = $aSize;
        $this->ix = $x;
        $this->iy = $y;
    }

    /**
     * @param $aColor
     */
    public function SetColor($aColor)
    {
        $this->iColor = $aColor;
    }

    /**
     * @param $aSize
     */
    public function SetSize($aSize)
    {
        $this->iSize = $aSize;
    }

    /**
     * @param $aType
     */
    public function SetType($aType)
    {
        $this->iType = $aType;
    }

    /**
     * @param $aImg
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg)
    {
        list($dx, $dy) = $this->isizespec[$this->iSize];
        $x = $this->ix;
        $y = $this->iy;
        switch ($this->iDirection) {
            case ARROW_DOWN:
                $c = array($x, $y, $x - $dx, $y - $dy, $x + $dx, $y - $dy, $x, $y);
                break;
            case ARROW_UP:
                $c = array($x, $y, $x - $dx, $y + $dy, $x + $dx, $y + $dy, $x, $y);
                break;
            case ARROW_LEFT:
                $c = array($x, $y, $x + $dy, $y - $dx, $x + $dy, $y + $dx, $x, $y);
                break;
            case ARROW_RIGHT:
                $c = array($x, $y, $x - $dy, $y - $dx, $x - $dy, $y + $dx, $x, $y);
                break;
            default:
                JpGraphError::RaiseL(6030);
                //('Unknown arrow direction for link.');
                die();
                break;
        }
        $aImg->SetColor($this->iColor);
        switch ($this->iType) {
            case ARROWT_SOLID:
                $aImg->FilledPolygon($c);
                break;
            case ARROWT_OPEN:
                $aImg->Polygon($c);
                break;
            default:
                JpGraphError::RaiseL(6031);
               throw new Exception('Unknown arrow type for link.');
        }
    }
}