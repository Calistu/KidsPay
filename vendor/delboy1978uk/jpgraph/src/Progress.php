<?php

/**
 * Class Progress
 */
class Progress
{
    /**
     * @var int
     */
    public $iProgress = -1;
    /**
     * @var int
     */
    public $iPattern = GANTT_SOLID;
    /**
     * @var string
     */
    /**
     * @var string
     */
    public $iColor = "black", $iFillColor = 'black';
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $iDensity = 98, $iHeight = 0.65;

    /**
     * @param $aProg
     * @throws JpGraphExceptionL
     */
    public function Set($aProg)
    {
        if ($aProg < 0.0 || $aProg > 1.0) {
            JpGraphError::RaiseL(6027);
            //("Progress value must in range [0, 1]");
        }
        $this->iProgress = $aProg;
    }

    /**
     * @param $aPattern
     * @param string $aColor
     * @param int $aDensity
     */
    public function SetPattern($aPattern, $aColor = "blue", $aDensity = 98)
    {
        $this->iPattern = $aPattern;
        $this->iColor = $aColor;
        $this->iDensity = $aDensity;
    }

    /**
     * @param $aColor
     */
    public function SetFillColor($aColor)
    {
        $this->iFillColor = $aColor;
    }

    /**
     * @param $aHeight
     */
    public function SetHeight($aHeight)
    {
        $this->iHeight = $aHeight;
    }
}