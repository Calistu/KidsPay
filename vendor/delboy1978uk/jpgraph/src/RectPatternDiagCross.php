<?php

/**
 * Class RectPatternDiagCross
 */
class RectPatternDiagCross extends RectPattern
{
    /**
     * @var RectPatternLDiag|null
     */
    private $left = null;
    /**
     * @var RectPatternRDiag|null
     */
    private $right = null;

    /**
     * RectPatternDiagCross constructor.
     * @param string $aColor
     * @param int $aWeight
     */
    public function __construct($aColor = "black", $aWeight = 1)
    {
        parent::__construct($aColor, $aWeight);
        $this->right = new RectPatternRDiag($aColor, $aWeight);
        $this->left = new RectPatternLDiag($aColor, $aWeight);
    }

    /**
     * @param $aDepth
     */
    public function SetOrder($aDepth)
    {
        $this->left->SetOrder($aDepth);
        $this->right->SetOrder($aDepth);
    }

    /**
     * @param $aRect
     */
    public function SetPos($aRect)
    {
        parent::SetPos($aRect);
        $this->left->SetPos($aRect);
        $this->right->SetPos($aRect);
    }

    /**
     * @param $aDens
     * @throws JpGraphExceptionL
     */
    public function SetDensity($aDens)
    {
        $this->left->SetDensity($aDens);
        $this->right->SetDensity($aDens);
    }

    /**
     * @param $aImg
     */
    public function DoPattern($aImg)
    {
        $this->left->DoPattern($aImg);
        $this->right->DoPattern($aImg);
    }

}

