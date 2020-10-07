<?php

/**
 * Class TextPropertyBelow
 */
class TextPropertyBelow extends TextProperty
{
    /**
     * TextPropertyBelow constructor.
     * @param string $aTxt
     */
    public function __construct($aTxt = '')
    {
        parent::__construct($aTxt);
    }

    /**
     * @param $aImg
     * @param int $aMargin
     * @return array
     */
    public function GetColWidth($aImg, $aMargin = 0)
    {
        // Since we are not stroking the title in the columns
        // but rather under the graph we want this to return 0.
        return array(0);
    }
}