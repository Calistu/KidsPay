<?php

/**
 * Class GanttConstraint
 */
class GanttConstraint
{
    /**
     * @var
     */
    public $iConstrainRow;
    /**
     * @var
     */
    public $iConstrainType;
    /**
     * @var
     */
    public $iConstrainColor;
    /**
     * @var
     */
    public $iConstrainArrowSize;
    /**
     * @var
     */
    public $iConstrainArrowType;

    //---------------
    // CONSTRUCTOR
    /**
     * GanttConstraint constructor.
     * @param $aRow
     * @param $aType
     * @param $aColor
     * @param $aArrowSize
     * @param $aArrowType
     */
    public function __construct($aRow, $aType, $aColor, $aArrowSize, $aArrowType)
    {
        $this->iConstrainType = $aType;
        $this->iConstrainRow = $aRow;
        $this->iConstrainColor = $aColor;
        $this->iConstrainArrowSize = $aArrowSize;
        $this->iConstrainArrowType = $aArrowType;
    }
}