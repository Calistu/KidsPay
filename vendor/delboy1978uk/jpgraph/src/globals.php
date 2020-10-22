<?php

if (!CheckPHPVersion(MIN_PHPVERSION)) {
    JpGraphError::RaiseL(13, PHP_VERSION, MIN_PHPVERSION);
    throw new Exception();
}

if (!function_exists("imagetypes") || !function_exists('imagecreatefromstring')) {
    JpGraphError::RaiseL(25001);
}

if (!function_exists('mb_strlen')) {
    JpGraphError::RaiseL(25500);
}

if (INSTALL_PHP_ERR_HANDLER) {
    set_error_handler("_phpErrorHandler");
}

if (isset($GLOBALS['php_errormsg']) && CATCH_PHPERRMSG && !preg_match('/|Deprecated|/i', $GLOBALS['php_errormsg'])) {
    JpGraphError::RaiseL(25004, $GLOBALS['php_errormsg']);
}

if (!USE_IMAGE_ERROR_HANDLER) {
    JpGraphError::SetImageFlag(false);
}


global $__jpg_err_locale;
global $__jpg_OldHandler;

$_gFlagCache = array(
    1 => null,
    2 => null,
    3 => null,
    4 => null,
);
$__jpg_err_locale = DEFAULT_ERR_LOCALE;
//$__jpg_OldHandler = set_exception_handler(array('JpGraphException', 'defaultHandler'));
$_gPredefIcons = new PredefIcons();
$gDateLocale = new DateLocale();
$gJpgDateLocale = new DateLocale();

