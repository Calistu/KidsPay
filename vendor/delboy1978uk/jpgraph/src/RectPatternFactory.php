<?php

/**
 * Class RectPatternFactory
 */
class RectPatternFactory
{
    /**
     * RectPatternFactory constructor.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * @param $aPattern
     * @param $aColor
     * @param int $aWeight
     * @return RectPattern3DPlane|RectPatternCross|RectPatternHor|RectPatternLDiag|RectPatternRDiag|RectPatternSolid|RectPatternVert
     * @throws JpGraphExceptionL
     */
    public function Create($aPattern, $aColor, $aWeight = 1)
    {
        switch ($aPattern) {
            case BAND_RDIAG:
                $obj = new RectPatternRDiag($aColor, $aWeight);
                break;
            case BAND_LDIAG:
                $obj = new RectPatternLDiag($aColor, $aWeight);
                break;
            case BAND_SOLID:
                $obj = new RectPatternSolid($aColor, $aWeight);
                break;
            case BAND_VLINE:
                $obj = new RectPatternVert($aColor, $aWeight);
                break;
            case BAND_HLINE:
                $obj = new RectPatternHor($aColor, $aWeight);
                break;
            case BAND_3DPLANE:
                $obj = new RectPattern3DPlane($aColor, $aWeight);
                break;
            case BAND_HVCROSS:
                $obj = new RectPatternCross($aColor, $aWeight);
                break;
            case BAND_DIAGCROSS:
                $obj = new RectPatternDiagCross($aColor, $aWeight);
                break;
            default:
                JpGraphError::RaiseL(16003, $aPattern);
            //(" Unknown pattern specification ($aPattern)");
        }
        return $obj;
    }
}