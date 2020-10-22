<?php

//gd image
define('LINESTYLE_SOLID', 1);
define('LINESTYLE_DOTTED', 2);
define('LINESTYLE_DASHED', 3);
define('LINESTYLE_LONGDASH', 4);

// jpg config inc
define('CSIMCACHE_DIR','csimcache/');
define('CSIMCACHE_HTTP_DIR','csimcache/');
define('DEFAULT_ERR_LOCALE','en');
define('DEFAULT_GFORMAT','auto');
define('USE_CACHE',false);
define('READ_CACHE',true);
define('USE_IMAGE_ERROR_HANDLER',true);
define('CATCH_PHPERRMSG',true);
define('INSTALL_PHP_ERR_HANDLER',false);
define('ERR_DEPRECATED',true);
define('USE_LIBRARY_IMAGETTFBBOX',true);
define('CACHE_FILE_GROUP','www');
define('CACHE_FILE_MOD',0664);
define('DEFAULT_THEME_CLASS', 'UniversalTheme');
define('SUPERSAMPLING', true);
define('SUPERSAMPLING_SCALE', 1);

// jpgraph
define('JPG_VERSION','4.2.6');
define('MIN_PHPVERSION','5.1.0');
define('_CSIM_SPECIALFILE','_csim_special_');
define('_CSIM_DISPLAY','_jpg_csimd');
define('_IMG_HANDLER','__handle');
define('_IMG_AUTO','auto');
define("TICKD_DENSE",1);
define("TICKD_NORMAL",2);
define("TICKD_SPARSE",3);
define("TICKD_VERYSPARSE",4);
define("SIDE_LEFT",-1);
define("SIDE_RIGHT",1);
define("SIDE_DOWN",-1);
define("SIDE_BOTTOM",-1);
define("SIDE_UP",1);
define("SIDE_TOP",1);
define("LEGEND_VERT",0);
define("LEGEND_HOR",1);
define("MARK_SQUARE",1);
define("MARK_UTRIANGLE",2);
define("MARK_DTRIANGLE",3);
define("MARK_DIAMOND",4);
define("MARK_CIRCLE",5);
define("MARK_FILLEDCIRCLE",6);
define("MARK_CROSS",7);
define("MARK_STAR",8);
define("MARK_X",9);
define("MARK_LEFTTRIANGLE",10);
define("MARK_RIGHTTRIANGLE",11);
define("MARK_FLASH",12);
define("MARK_IMG",13);
define("MARK_FLAG1",14);
define("MARK_FLAG2",15);
define("MARK_FLAG3",16);
define("MARK_FLAG4",17);
define("MARK_IMG_PUSHPIN",50);
define("MARK_IMG_SPUSHPIN",50);
define("MARK_IMG_LPUSHPIN",51);
define("MARK_IMG_DIAMOND",52);
define("MARK_IMG_SQUARE",53);
define("MARK_IMG_STAR",54);
define("MARK_IMG_BALL",55);
define("MARK_IMG_SBALL",55);
define("MARK_IMG_MBALL",56);
define("MARK_IMG_LBALL",57);
define("MARK_IMG_BEVEL",58);
define("INLINE_YES",1);
define("INLINE_NO",0);
define("BGIMG_FILLPLOT",1);
define("BGIMG_FILLFRAME",2);
define("BGIMG_COPY",3);
define("BGIMG_CENTER",4);
define("BGIMG_FREE",5);
define("DEPTH_BACK",0);
define("DEPTH_FRONT",1);
define("VERTICAL",1);
define("HORIZONTAL",0);
define('AXSTYLE_SIMPLE',1);
define('AXSTYLE_BOXIN',2);
define('AXSTYLE_BOXOUT',3);
define('AXSTYLE_YBOXIN',4);
define('AXSTYLE_YBOXOUT',5);
define('TITLEBKG_STYLE1',1);
define('TITLEBKG_STYLE2',2);
define('TITLEBKG_STYLE3',3);
define('TITLEBKG_FRAME_NONE',0);
define('TITLEBKG_FRAME_FULL',1);
define('TITLEBKG_FRAME_BOTTOM',2);
define('TITLEBKG_FRAME_BEVEL',3);
define('TITLEBKG_FILLSTYLE_HSTRIPED',1);
define('TITLEBKG_FILLSTYLE_VSTRIPED',2);
define('TITLEBKG_FILLSTYLE_SOLID',3);
define('LABELBKG_NONE',0);
define('LABELBKG_XAXIS',1);
define('LABELBKG_YAXIS',2);
define('LABELBKG_XAXISFULL',3);
define('LABELBKG_YAXISFULL',4);
define('LABELBKG_XYFULL',5);
define('LABELBKG_XY',6);
define('BGRAD_FRAME',1);
define('BGRAD_MARGIN',2);
define('BGRAD_PLOT',3);
define('TABTITLE_WIDTHFIT',0);
define('TABTITLE_WIDTHFULL',-1);
define('SKEW3D_UP',0);
define('SKEW3D_DOWN',1);
define('SKEW3D_LEFT',2);
define('SKEW3D_RIGHT',3);
define("_JPG_DEBUG",false);
define("_FORCE_IMGTOFILE",false);
define("_FORCE_IMGDIR",'/tmp/jpgimg/');

// bar
define('PATTERN_DIAG1', 1);
define('PATTERN_DIAG2', 2);
define('PATTERN_DIAG3', 3);
define('PATTERN_DIAG4', 4);
define('PATTERN_CROSS1', 5);
define('PATTERN_CROSS2', 6);
define('PATTERN_CROSS3', 7);
define('PATTERN_CROSS4', 8);
define('PATTERN_STRIPE1', 9);
define('PATTERN_STRIPE2', 10);

// canv tools
define('CORNER_TOPLEFT',0);
define('CORNER_TOPRIGHT',1);
define('CORNER_BOTTOMRIGHT',2);
define('CORNER_BOTTOMLEFT',3);

// contour
define('HORIZ_EDGE',0);
define('VERT_EDGE',1);

// date
define('HOURADJ_1',0+30);
define('HOURADJ_2',1+30);
define('HOURADJ_3',2+30);
define('HOURADJ_4',3+30);
define('HOURADJ_6',4+30);
define('HOURADJ_12',5+30);
define('MINADJ_1',0+20);
define('MINADJ_5',1+20);
define('MINADJ_10',2+20);
define('MINADJ_15',3+20);
define('MINADJ_30',4+20);
define('SECADJ_1',0);
define('SECADJ_5',1);
define('SECADJ_10',2);
define('SECADJ_15',3);
define('SECADJ_30',4);
define('YEARADJ_1',0+30);
define('YEARADJ_2',1+30);
define('YEARADJ_5',2+30);
define('MONTHADJ_1',0+20);
define('MONTHADJ_6',1+20);
define('DAYADJ_1',0);
define('DAYADJ_WEEK',1);
define('DAYADJ_7',1);
define('SECPERYEAR',31536000);
define('SECPERDAY',86400);
define('SECPERHOUR',3600);
define('SECPERMIN',60);

// flags
define('FLAGSIZE1', 1);
define('FLAGSIZE2', 2);
define('FLAGSIZE3', 3);
define('FLAGSIZE4', 4);

// plotband
define("BAND_RDIAG", 1); // Right diagonal lines
define("BAND_LDIAG", 2); // Left diagonal lines
define("BAND_SOLID", 3); // Solid one color
define("BAND_VLINE", 4); // Vertical lines
define("BAND_HLINE", 5);  // Horizontal lines
define("BAND_3DPLANE", 6);  // "3D" Plane
define("BAND_HVCROSS", 7);  // Vertical/Hor crosses
define("BAND_DIAGCROSS", 8); // Diagonal crosses

// gantt
define('MAX_GANTTIMG_SIZE_W',8000);
define('MAX_GANTTIMG_SIZE_H',5000);
define("GANTT_HDAY",1);
define("GANTT_HWEEK",2);
define("GANTT_HMONTH",4);
define("GANTT_HYEAR",8);
define("GANTT_HHOUR",16);
define("GANTT_HMIN",32);
define("GANTT_RDIAG",BAND_RDIAG); // Right diagonal lines
define("GANTT_LDIAG",BAND_LDIAG); // Left diagonal lines
define("GANTT_SOLID",BAND_SOLID); // Solid one color
define("GANTT_VLINE",BAND_VLINE); // Vertical lines
define("GANTT_HLINE",BAND_HLINE);  // Horizontal lines
define("GANTT_3DPLANE",BAND_3DPLANE);  // "3D" Plane
define("GANTT_HVCROSS",BAND_HVCROSS);  // Vertical/Hor crosses
define("GANTT_DIAGCROSS",BAND_DIAGCROSS); // Diagonal crosses
define("LOCALE_EN","en_UK");
define("LOCALE_SV","sv_SE");
define("GANTT_EVEN",1);
define("GANTT_FROMTOP",2);
define("MINUTESTYLE_MM",0);  // 15
define("MINUTESTYLE_CUSTOM",2);  // Custom format
define("HOURSTYLE_HM24",0);  // 13:10
define("HOURSTYLE_HMAMPM",1);  // 1:10pm
define("HOURSTYLE_H24",2);  // 13
define("HOURSTYLE_HAMPM",3);  // 1pm
define("HOURSTYLE_CUSTOM",4);  // User defined
define("DAYSTYLE_ONELETTER",0);  // "M"
define("DAYSTYLE_LONG",1);  // "Monday"
define("DAYSTYLE_LONGDAYDATE1",2); // "Monday 23 Jun"
define("DAYSTYLE_LONGDAYDATE2",3); // "Monday 23 Jun 2003"
define("DAYSTYLE_SHORT",4);  // "Mon"
define("DAYSTYLE_SHORTDAYDATE1",5); // "Mon 23/6"
define("DAYSTYLE_SHORTDAYDATE2",6); // "Mon 23 Jun"
define("DAYSTYLE_SHORTDAYDATE3",7); // "Mon 23"
define("DAYSTYLE_SHORTDATE1",8); // "23/6"
define("DAYSTYLE_SHORTDATE2",9); // "23 Jun"
define("DAYSTYLE_SHORTDATE3",10); // "Mon 23"
define("DAYSTYLE_SHORTDATE4",11); // "23"
define("DAYSTYLE_CUSTOM",12);  // "M"
define("WEEKSTYLE_WNBR",0);
define("WEEKSTYLE_FIRSTDAY",1);
define("WEEKSTYLE_FIRSTDAY2",2);
define("WEEKSTYLE_FIRSTDAYWNBR",3);
define("WEEKSTYLE_FIRSTDAY2WNBR",4);
define("MONTHSTYLE_SHORTNAME",0);
define("MONTHSTYLE_LONGNAME",1);
define("MONTHSTYLE_LONGNAMEYEAR2",2);
define("MONTHSTYLE_SHORTNAMEYEAR2",3);
define("MONTHSTYLE_LONGNAMEYEAR4",4);
define("MONTHSTYLE_SHORTNAMEYEAR4",5);
define("MONTHSTYLE_FIRSTLETTER",6);
define('CONSTRAIN_STARTSTART',0);
define('CONSTRAIN_STARTEND',1);
define('CONSTRAIN_ENDSTART',2);
define('CONSTRAIN_ENDEND',3);
define('ARROW_DOWN',0);
define('ARROW_UP',1);
define('ARROW_LEFT',2);
define('ARROW_RIGHT',3);
define('ARROWT_SOLID',0);
define('ARROWT_OPEN',1);
define('ARROW_S1',0);
define('ARROW_S2',1);
define('ARROW_S3',2);
define('ARROW_S4',3);
define('ARROW_S5',4);
define('ACTYPE_NORMAL',0);
define('ACTYPE_GROUP',1);
define('ACTYPE_MILESTONE',2);
define('ACTINFO_3D',1);
define('ACTINFO_2D',0);
define('GICON_WARNINGRED',0);
define('GICON_TEXT',1);
define('GICON_ENDCONS',2);
define('GICON_MAIL',3);
define('GICON_STARTCONS',4);
define('GICON_CALC',5);
define('GICON_MAGNIFIER',6);
define('GICON_LOCK',7);
define('GICON_STOP',8);
define('GICON_WARNINGYELLOW',9);
define('GICON_FOLDEROPEN',10);
define('GICON_FOLDER',11);
define('GICON_TEXTIMPORTANT',12);
define('GANTT_HGRID1',0);
define('GANTT_HGRID2',1);

// led
define('LEDC_RED', 0);
define('LEDC_GREEN', 1);
define('LEDC_BLUE', 2);
define('LEDC_YELLOW', 3);
define('LEDC_GRAY', 4);
define('LEDC_CHOCOLATE', 5);
define('LEDC_PERU', 6);
define('LEDC_GOLDENROD', 7);
define('LEDC_KHAKI', 8);
define('LEDC_OLIVE', 9);
define('LEDC_LIMEGREEN', 10);
define('LEDC_FORESTGREEN', 11);
define('LEDC_TEAL', 12);
define('LEDC_STEELBLUE', 13);
define('LEDC_NAVY', 14);
define('LEDC_INVERTGRAY', 15);

// legend
define('_DEFAULT_LPM_SIZE', 8);

// line
define("LP_AREA_FILLED", true);
define("LP_AREA_NOT_FILLED", false);
define("LP_AREA_BORDER",false);
define("LP_AREA_NO_BORDER",true);

// log
define('LOGLABELS_PLAIN', 0);
define('LOGLABELS_MAGNITUDE', 1);

// pie
define("PIE_VALUE_ABS",1);
define("PIE_VALUE_PER",0);
define("PIE_VALUE_PERCENTAGE",0);
define("PIE_VALUE_ADJPERCENTAGE",2);
define("PIE_VALUE_ADJPER",2);


// polar
define('POLAR_360',1);
define('POLAR_180',2);

// table
define('TGRID_SINGLE',1);
define('TGRID_DOUBLE',2);
define('TGRID_DOUBLE2',3);
define('TIMG_WIDTH',1);
define('TIMG_HEIGHT',2);

// ttf
define("FF_COURIER",10);
define("FF_VERDANA",11);
define("FF_TIMES",12);
define("FF_COMIC",14);
define("FF_ARIAL",15);
define("FF_GEORGIA",16);
define("FF_TREBUCHE",17);
define("FF_VERA",18);
define("FF_VERAMONO",19);
define("FF_VERASERIF",20);
define("FF_SIMSUN",30);
define("FF_CHINESE",31);
define("FF_BIG5",32);
define("FF_MINCHO",40);
define("FF_PMINCHO",41);
define("FF_GOTHIC",42);
define("FF_PGOTHIC",43);
define("FF_DAVID",44);
define("FF_MIRIAM",45);
define("FF_AHRON",46);
define("FF_DV_SANSSERIF",47);
define("FF_DV_SERIF",48);
define("FF_DV_SANSSERIFMONO",49);
define("FF_DV_SERIFCOND",50);
define("FF_DV_SANSSERIFCOND",51);
define("FF_DIGITAL",72); // Digital readout font
define("FF_COMPUTER",73); // The classic computer font
define("FF_CALCULATOR",74); // Triad font
define("FF_USERFONT",90);
define("FF_USERFONT1",90);
define("FF_USERFONT2",91);
define("FF_USERFONT3",92);
define("_FIRST_FONT",10);
define("_LAST_FONT",99);
define("FS_NORMAL",9001);
define("FS_BOLD",9002);
define("FS_ITALIC",9003);
define("FS_BOLDIT",9004);
define("FS_BOLDITALIC",9004);
define("FF_FONT0",1);
define("FF_FONT1",2);
define("FF_FONT2",4);

define("GRAD_VER", 1);
define("GRAD_VERT", 1);
define("GRAD_HOR", 2);
define("GRAD_MIDHOR", 3);
define("GRAD_MIDVER", 4);
define("GRAD_CENTER", 5);
define("GRAD_WIDE_MIDVER", 6);
define("GRAD_WIDE_MIDHOR", 7);
define("GRAD_LEFT_REFLECTION", 8);
define("GRAD_RIGHT_REFLECTION", 9);
define("GRAD_RAISED_PANEL", 10);
define("GRAD_DIAGONAL", 11);

define('CHINESE_TTF_FONT','bkai00mp.ttf');
define("LANGUAGE_GREEK",false);
define("GREEK_FROM_WINDOWS",false);
define("LANGUAGE_CYRILLIC",false);
define("CYRILLIC_FROM_WINDOWS",false);
define('LANGUAGE_CHARSET', null);
define('MINCHO_TTF_FONT','ipam.ttf');
define('PMINCHO_TTF_FONT','ipamp.ttf');
define('GOTHIC_TTF_FONT','ipag.ttf');
define('PGOTHIC_TTF_FONT','ipagp.ttf');
define('ASSUME_EUCJP_ENCODING',false);
define('FF_DEFAULT', FF_DV_SANSSERIF);

// utils
define('DSUTILS_MONTH', 1); // Major and minor ticks on a monthly basis
define('DSUTILS_MONTH1', 1); // Major and minor ticks on a monthly basis
define('DSUTILS_MONTH2', 2); // Major ticks on a bi-monthly basis
define('DSUTILS_MONTH3', 3); // Major icks on a tri-monthly basis
define('DSUTILS_MONTH6', 4); // Major on a six-monthly basis
define('DSUTILS_WEEK1', 5); // Major ticks on a weekly basis
define('DSUTILS_WEEK2', 6); // Major ticks on a bi-weekly basis
define('DSUTILS_WEEK4', 7); // Major ticks on a quod-weekly basis
define('DSUTILS_DAY1', 8); // Major ticks on a daily basis
define('DSUTILS_DAY2', 9); // Major ticks on a bi-daily basis
define('DSUTILS_DAY4', 10); // Major ticks on a qoud-daily basis
define('DSUTILS_YEAR1', 11); // Major ticks on a yearly basis
define('DSUTILS_YEAR2', 12); // Major ticks on a bi-yearly basis
define('DSUTILS_YEAR5', 13); // Major ticks on a five-yearly basis
define('__LR_EPSILON', 1.0e-8);

// windrose
define('WINDROSE_TYPE4', 1);
define('WINDROSE_TYPE8', 2);
define('WINDROSE_TYPE16', 3);
define('WINDROSE_TYPEFREE', 4);
define('LBLALIGN_CENTER', 1);
define('LBLALIGN_TOP', 2);
define('LBLPOSITION_CENTER', 1);
define('LBLPOSITION_EDGE', 2);
define('KEYENCODING_CLOCKWISE', 1);
define('KEYENCODING_ANTICLOCKWISE', 2);
define('__DEBUG', false);
define('RANGE_OVERLAPPING', 0);
define('RANGE_DISCRETE', 1);

// lang/prod
define('DEFAULT_ERROR_MESSAGE', 'We are sorry but the system could not generate the requested image. Please contact site support to resolve this problem. Problem no: #');


// jpgraph again
if (USE_CACHE) {
    if (!defined('CACHE_DIR')) {
        if (strstr(PHP_OS, 'WIN')) {
            if (empty($_SERVER['TEMP'])) {
                $t = new ErrMsgText();
                $msg = $t->Get(11, $file, $lineno);
                die($msg);
            } else {
                define('CACHE_DIR', $_SERVER['TEMP'] . '/');
            }
        } else {
            define('CACHE_DIR', '/tmp/jpgraph_cache/');
        }
    }
} elseif (!defined('CACHE_DIR')) {
    define('CACHE_DIR', '');
}

if (!defined('TTF_DIR')) {
    if (strstr(PHP_OS, 'WIN')) {
        $sroot = getenv('SystemRoot');
        if (empty($sroot)) {
            $t = new ErrMsgText();
            $msg = $t->Get(12, $file, $lineno);
            die($msg);
        } else {
            define('TTF_DIR', $sroot . '/fonts/');
        }
    } else {
        define('TTF_DIR', '/usr/share/fonts/truetype/');
    }
}

//
// Setup path for MultiByte TTF fonts (japanese, chinese etc.)
//
if (!defined('MBTTF_DIR')) {
    if (strstr(PHP_OS, 'WIN')) {
        $sroot = getenv('SystemRoot');
        if (empty($sroot)) {
            $t = new ErrMsgText();
            $msg = $t->Get(12, $file, $lineno);
            die($msg);
        } else {
            define('MBTTF_DIR', $sroot . '/fonts/');
        }
    } else {
        define('MBTTF_DIR', '/usr/share/fonts/truetype/');
    }
}

