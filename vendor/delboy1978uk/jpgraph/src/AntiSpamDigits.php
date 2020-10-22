<?php


/**
 * Class AntiSpamDigits
 */
class AntiSpamDigits
{

    /**
     * @var string
     */
    private $iNumber = '';

    /**
     * AntiSpamDigits constructor.
     * @param string $aNumber
     */
    public function __construct($aNumber = '')
    {
        $this->iNumber = $aNumber;
    }

    /**
     * @param $aLen
     * @return string
     */
    public function Rand($aLen)
    {
        $d = '';
        for ($i = 0; $i < $aLen; ++$i) {
            $d .= rand(1, 9);
        }
        $this->iNumber = $d;
        return $d;
    }

    /**
     * @return bool
     */
    public function Stroke()
    {

        $n = strlen($this->iNumber);
        for ($i = 0; $i < $n; ++$i) {
            if (!is_numeric($this->iNumber[$i]) || $this->iNumber[$i] == 0) {
                return false;
            }
        }

        $dd = new AntiSpamHandDigits();
        $n = strlen($this->iNumber);
        $img = @imagecreatetruecolor($n * $dd->iWidth, $dd->iHeight);
        if ($img < 1) {
            return false;
        }
        $start = 0;
        for ($i = 0; $i < $n; ++$i) {
            $dimg = imagecreatefromstring(base64_decode($dd->digits[$this->iNumber[$i]][1]));
            imagecopy($img, $dimg, $start, 0, 0, 0, imagesx($dimg), $dd->iHeight);
            $start += imagesx($dimg);
        }
        $resimg = @imagecreatetruecolor($start + 4, $dd->iHeight + 4);
        if ($resimg < 1) {
            return false;
        }
        imagecopy($resimg, $img, 2, 2, 0, 0, $start, $dd->iHeight);
        header("Content-type: image/jpeg");
        imagejpeg($resimg);
        return true;
    }
}

