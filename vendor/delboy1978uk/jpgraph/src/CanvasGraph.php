<?php


/**
 * Class CanvasGraph
 */
class CanvasGraph extends Graph
{
    //---------------
    // CONSTRUCTOR
    /**
     * CanvasGraph constructor.
     * @param int $aWidth
     * @param int $aHeight
     * @param string $aCachedName
     * @param int $timeout
     * @param int $inline
     * @throws JpGraphExceptionL
     */
    public function __construct($aWidth = 300, $aHeight = 200, $aCachedName = "", $timeout = 0, $inline = 1)
    {
        parent::__construct($aWidth, $aHeight, $aCachedName, $timeout, $inline);
    }

    //---------------
    // PUBLIC METHODS

    /**
     * @throws JpGraphExceptionL
     */
    public function InitFrame()
    {
        $this->StrokePlotArea();
    }

    // Method description

    /**
     * @param string $aStrokeFileName
     * @return bool|null
     * @throws JpGraphExceptionL
     */
    public function Stroke($aStrokeFileName = "")
    {
        if ($this->texts != null) {
            for ($i = 0; $i < count($this->texts); ++$i) {
                $this->texts[$i]->Stroke($this->img);
            }
        }
        if ($this->iTables !== null) {
            for ($i = 0; $i < count($this->iTables); ++$i) {
                $this->iTables[$i]->Stroke($this->img);
            }
        }
        $this->StrokeTitles();

        // If the filename is the predefined value = '_csim_special_'
        // we assume that the call to stroke only needs to do enough
        // to correctly generate the CSIM maps.
        // We use this variable to skip things we don't strictly need
        // to do to generate the image map to improve performance
        // a best we can. Therefor you will see a lot of tests !$_csim in the
        // code below.
        $_csim = ($aStrokeFileName === _CSIM_SPECIALFILE);

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the CSIM hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // CSIM without storing an image to disk GetCSIM must call Stroke.
        $this->iHasStroked = true;

        if (!$_csim) {

            // Should we do any final image transformation
            if ($this->iImgTrans) {
                $tform = new ImgTrans($this->img->img);
                $this->img->img = $tform->Skew3D($this->iImgTransHorizon, $this->iImgTransSkewDist,
                    $this->iImgTransDirection, $this->iImgTransHighQ,
                    $this->iImgTransMinSize, $this->iImgTransFillColor,
                    $this->iImgTransBorder);
            }


            // If the filename is given as the special _IMG_HANDLER
            // then the image handler is returned and the image is NOT
            // streamed back
            if ($aStrokeFileName == _IMG_HANDLER) {
                return $this->img->img;
            } else {
                // Finally stream the generated picture
                $this->cache->PutAndStream($this->img, $this->cache_name, $this->inline, $aStrokeFileName);
                return true;
            }
        }
    }
} 