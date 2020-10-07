<?php

//===================================================
// CLASS FuncGenerator
// Description: Utility class to help generate data for function plots.
// The class supports both parametric and regular functions.
//===================================================

/**
 * Class FuncGenerator
 */
class FuncGenerator
{
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $iFunc = '', $iXFunc = '', $iMin, $iMax, $iStepSize;

    /**
     * FuncGenerator constructor.
     * @param $aFunc
     * @param string $aXFunc
     */
    public function __construct($aFunc, $aXFunc = '')
    {
        $this->iFunc = $aFunc;
        $this->iXFunc = $aXFunc;
    }

    /**
     * @param $aXMin
     * @param $aXMax
     * @param int $aSteps
     * @return array
     * @throws JpGraphExceptionL
     */
    public function E($aXMin, $aXMax, $aSteps = 50)
    {
        $this->iMin = $aXMin;
        $this->iMax = $aXMax;
        $this->iStepSize = ($aXMax - $aXMin) / $aSteps;

        if ($this->iXFunc != '') {
            $t = 'for($i=' . $aXMin . '; $i<=' . $aXMax . '; $i += ' . $this->iStepSize . ') {$ya[]=' . $this->iFunc . ';$xa[]=' . $this->iXFunc . ';}';
        } elseif ($this->iFunc != '') {
            $t = 'for($x=' . $aXMin . '; $x<=' . $aXMax . '; $x += ' . $this->iStepSize . ') {$ya[]=' . $this->iFunc . ';$xa[]=$x;} $x=' . $aXMax . ';$ya[]=' . $this->iFunc . ';$xa[]=$x;';
        } else {
            JpGraphError::RaiseL(24001);
        }
        @eval($t);

        // If there is an error in the function specifcation this is the only
        // way we can discover that.
        if (empty($xa) || empty($ya)) {
            JpGraphError::RaiseL(24002);
        }//('FuncGenerator : Syntax error in function specification ');

        return array($xa, $ya);
    }
}