<?php

/**
 * Class FlagCache
 */
class FlagCache
{
    /**
     * @param $aSize
     * @param $aName
     * @return mixed
     * @throws JpGraphExceptionL
     */
    public static function GetFlagImgByName($aSize, $aName)
    {
        global $_gFlagCache;

        if ($_gFlagCache[$aSize] === null) {
            $_gFlagCache[$aSize] = new FlagImages($aSize);
        }
        $f = $_gFlagCache[$aSize];
        /** @todo undefined $aFullName */
        $aFullName = '';
        $idx = $f->GetIdxByName($aName, $aFullName);
        return $f->GetImgByIdx($idx);
    }
}