<?php

/**
 * Class IconPlot
 */
class IconPlot
{
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var float|int
     */
    /**
     * @var float|int
     */
    public $iX = 0, $iY = 0, $iScale = 1.0, $iMix = 100;
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $iHorAnchor = 'left', $iVertAnchor = 'top';
    /**
     * @var string
     */
    private $iFile = '';
    /**
     * @var array
     */
    private $iAnchors = array('left', 'right', 'top', 'bottom', 'center');
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $iCountryFlag = '', $iCountryStdSize = 3;
    /**
     * @var null
     */
    /**
     * @var null
     */
    private $iScalePosY = null, $iScalePosX = null;
    /**
     * @var string
     */
    private $iImgString = '';


    /**
     * IconPlot constructor.
     * @param string $aFile
     * @param int $aX
     * @param int $aY
     * @param float $aScale
     * @param int $aMix
     * @throws JpGraphExceptionL
     */
    public function __construct($aFile = "", $aX = 0, $aY = 0, $aScale = 1.0, $aMix = 100)
    {
        $this->iFile = $aFile;
        $this->iX = $aX;
        $this->iY = $aY;
        $this->iScale = $aScale;
        if ($aMix < 0 || $aMix > 100) {
            JpGraphError::RaiseL(8001); //('Mix value for icon must be between 0 and 100.');
        }
        $this->iMix = $aMix;
    }

    /**
     * @param $aFlag
     * @param int $aX
     * @param int $aY
     * @param float $aScale
     * @param int $aMix
     * @param int $aStdSize
     * @throws JpGraphExceptionL
     */
    public function SetCountryFlag($aFlag, $aX = 0, $aY = 0, $aScale = 1.0, $aMix = 100, $aStdSize = 3)
    {
        $this->iCountryFlag = $aFlag;
        $this->iX = $aX;
        $this->iY = $aY;
        $this->iScale = $aScale;
        if ($aMix < 0 || $aMix > 100) {
            JpGraphError::RaiseL(8001);//'Mix value for icon must be between 0 and 100.');
        }
        $this->iMix = $aMix;
        $this->iCountryStdSize = $aStdSize;
    }

    /**
     * @param $aX
     * @param $aY
     */
    public function SetPos($aX, $aY)
    {
        $this->iX = $aX;
        $this->iY = $aY;
    }

    /**
     * @param $aStr
     */
    public function CreateFromString($aStr)
    {
        $this->iImgString = $aStr;
    }

    /**
     * @param $aX
     * @param $aY
     */
    public function SetScalePos($aX, $aY)
    {
        $this->iScalePosX = $aX;
        $this->iScalePosY = $aY;
    }

    /**
     * @param $aScale
     */
    public function SetScale($aScale)
    {
        $this->iScale = $aScale;
    }

    /**
     * @param $aMix
     * @throws JpGraphExceptionL
     */
    public function SetMix($aMix)
    {
        if ($aMix < 0 || $aMix > 100) {
            JpGraphError::RaiseL(8001);//('Mix value for icon must be between 0 and 100.');
        }
        $this->iMix = $aMix;
    }

    /**
     * @param string $aXAnchor
     * @param string $aYAnchor
     * @throws JpGraphExceptionL
     */
    public function SetAnchor($aXAnchor = 'left', $aYAnchor = 'center')
    {
        if (!in_array($aXAnchor, $this->iAnchors) ||
            !in_array($aYAnchor, $this->iAnchors)) {
            JpGraphError::RaiseL(8002);//("Anchor position for icons must be one of 'top', 'bottom', 'left', 'right' or 'center'");
        }
        $this->iHorAnchor = $aXAnchor;
        $this->iVertAnchor = $aYAnchor;
    }

    /**
     * @param $aGraph
     */
    public function PreStrokeAdjust($aGraph)
    {
        // Nothing to do ...
    }

    /**
     * @param $aGraph
     */
    public function DoLegend($aGraph)
    {
        // Nothing to do ...
    }

    /**
     * @return array
     */
    public function Max()
    {
        return array(false, false);
    }


    // The next four function are framework function tht gets called
    // from Gantt and is not menaiungfull in the context of Icons but
    // they must be implemented to avoid errors.
    /**
     * @return bool
     */
    public function GetMaxDate()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function GetMinDate()
    {
        return false;
    }

    /**
     * @return int
     */
    public function GetLineNbr()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function GetAbsHeight()
    {
        return 0;
    }


    /**
     * @return array
     */
    public function Min()
    {
        return array(false, false);
    }

    /**
     * @param $aImg
     * @return bool
     */
    public function StrokeMargin(&$aImg)
    {
        return true;
    }

    /**
     * @param $aImg
     * @param null $axscale
     * @param null $ayscale
     * @throws JpGraphExceptionL
     */
    public function Stroke($aImg, $axscale = null, $ayscale = null)
    {
        $this->StrokeWithScale($aImg, $axscale, $ayscale);
    }

    /**
     * @param $aImg
     * @param $axscale
     * @param $ayscale
     * @throws JpGraphExceptionL
     */
    public function StrokeWithScale($aImg, $axscale, $ayscale)
    {
        if ($this->iScalePosX === null || $this->iScalePosY === null ||
            $axscale === null || $ayscale === null) {
            $this->_Stroke($aImg);
        } else {
            $this->_Stroke($aImg,
                round($axscale->Translate($this->iScalePosX)),
                round($ayscale->Translate($this->iScalePosY)));
        }
    }

    /**
     *
     */
    public function GetWidthHeight()
    {
        $dummy = 0;
        return $this->_Stroke($dummy, null, null, true);
    }

    /**
     * @param $aImg
     * @param null $x
     * @param null $y
     * @param bool $aReturnWidthHeight
     * @return array|mixed
     * @throws JpGraphExceptionL
     */
    public function _Stroke($aImg, $x = null, $y = null, $aReturnWidthHeight = false)
    {
        if ($this->iFile != '' && $this->iCountryFlag != '') {
            JpGraphError::RaiseL(8003);//('It is not possible to specify both an image file and a country flag for the same icon.');
        }
        if ($this->iFile != '') {
            $gdimg = Graph::LoadBkgImage('', $this->iFile);
        } elseif ($this->iImgString != '') {
            $gdimg = Image::CreateFromString($this->iImgString);
        } else {
            if (!class_exists('FlagImages', false)) {
                JpGraphError::RaiseL(8004);//('In order to use Country flags as icons you must include the "jpgraph_flags.php" file.');
            }
            $fobj = new FlagImages($this->iCountryStdSize);
            $dummy = '';
            $gdimg = $fobj->GetImgByName($this->iCountryFlag, $dummy);
        }

        $iconw = imagesx($gdimg);
        $iconh = imagesy($gdimg);

        if ($aReturnWidthHeight) {
            return array(round($iconw * $this->iScale), round($iconh * $this->iScale));
        }

        if ($x !== null && $y !== null) {
            $this->iX = $x;
            $this->iY = $y;
        }
        if ($this->iX >= 0 && $this->iX <= 1.0) {
            $w = imagesx($aImg->img);
            $this->iX = round($w * $this->iX);
        }
        if ($this->iY >= 0 && $this->iY <= 1.0) {
            $h = imagesy($aImg->img);
            $this->iY = round($h * $this->iY);
        }

        if ($this->iHorAnchor == 'center') {
            $this->iX -= round($iconw * $this->iScale / 2);
        }
        if ($this->iHorAnchor == 'right') {
            $this->iX -= round($iconw * $this->iScale);
        }
        if ($this->iVertAnchor == 'center') {
            $this->iY -= round($iconh * $this->iScale / 2);
        }
        if ($this->iVertAnchor == 'bottom') {
            $this->iY -= round($iconh * $this->iScale);
        }

        $aImg->CopyMerge($gdimg, $this->iX, $this->iY, 0, 0,
            round($iconw * $this->iScale), round($iconh * $this->iScale),
            $iconw, $iconh,
            $this->iMix);
    }
}


