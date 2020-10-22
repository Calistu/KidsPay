<?php

// A wrapper class that is used to access the specified error object
// (to hide the global error parameter and avoid having a GLOBAL directive
// in all methods.
//

/**
 * Class JpGraphError
 */
class JpGraphError
{
    /**
     * @var bool
     */
    private static $__iImgFlg = true;
    /**
     * @var string
     */
    private static $__iLogFile = '';
    /**
     * @var string
     */
    private static $__iTitle = 'JpGraph Error: ';

    /**
     * @param $aMsg
     * @param bool $aHalt
     * @throws JpGraphException
     */
    public static function Raise($aMsg, $aHalt = true)
    {
        throw new JpGraphException($aMsg);
    }

    /**
     * @param $aLoc
     */
    public static function SetErrLocale($aLoc)
    {
        global $__jpg_err_locale;
        $__jpg_err_locale = $aLoc;
    }

    /**
     * @param $errnbr
     * @param null $a1
     * @param null $a2
     * @param null $a3
     * @param null $a4
     * @param null $a5
     * @throws JpGraphExceptionL
     */
    public static function RaiseL($errnbr, $a1 = null, $a2 = null, $a3 = null, $a4 = null, $a5 = null)
    {
        throw new JpGraphExceptionL($errnbr, $a1, $a2, $a3, $a4, $a5);
    }

    /**
     * @param bool $aFlg
     */
    public static function SetImageFlag($aFlg = true)
    {
        self::$__iImgFlg = $aFlg;
    }

    /**
     * @return bool
     */
    public static function GetImageFlag()
    {
        return self::$__iImgFlg;
    }

    /**
     * @param $aFile
     */
    public static function SetLogFile($aFile)
    {
        self::$__iLogFile = $aFile;
    }

    /**
     * @return string
     */
    public static function GetLogFile()
    {
        return self::$__iLogFile;
    }

    /**
     * @param $aTitle
     */
    public static function SetTitle($aTitle)
    {
        self::$__iTitle = $aTitle;
    }

    /**
     * @return string
     */
    public static function GetTitle()
    {
        return self::$__iTitle;
    }
}