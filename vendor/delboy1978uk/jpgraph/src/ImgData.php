<?php

/**
 * Class ImgData
 */
class ImgData
{
    /**
     * @var string
     */
    protected $name = '';  // Each subclass gives a name
    /**
     * @var array
     */
    protected $an = array();  // Data array names
    /**
     * @var array
     */
    protected $colors = array(); // Available colors
    /**
     * @var array
     */
    protected $index = array(); // Index for colors
    /**
     * @var int
     */
    protected $maxidx = 0;  // Max color index
    /**
     * @var float
     */
    /**
     * @var float
     */
    protected $anchor_x = 0.5, $anchor_y = 0.5;    // Where is the center of the image

    // Create a GD image from the data and return a GD handle
    /**
     * @param $aMark
     * @param $aIdx
     * @return resource
     * @throws JpGraphExceptionL
     */
    public function GetImg($aMark, $aIdx)
    {
        $n = $this->an[$aMark];
        if (is_string($aIdx)) {
            if (!in_array($aIdx, $this->colors)) {
                JpGraphError::RaiseL(23001, $this->name, $aIdx);//('This marker "'.($this->name).'" does not exist in color: '.$aIdx);
            }
            $idx = $this->index[$aIdx];
        } elseif (!is_integer($aIdx) ||
            (is_integer($aIdx) && $aIdx > $this->maxidx)) {
            JpGraphError::RaiseL(23002, $this->name);//('Mark color index too large for marker "'.($this->name).'"');
        } else
            $idx = $aIdx;
        return Image::CreateFromString(base64_decode($this->{$n}[$idx][1]));
    }

    /**
     * @return array
     */
    public function GetAnchor()
    {
        return array($this->anchor_x, $this->anchor_y);
    }
}