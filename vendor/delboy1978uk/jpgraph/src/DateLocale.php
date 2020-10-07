<?php


//===================================================
// CLASS DateLocale
// Description: Hold localized text used in dates
//===================================================

/**
 * Class DateLocale
 */
class DateLocale
{

    /**
     * @var string
     */
    public $iLocale = 'C'; // environmental locale be used by default
    /**
     * @var null
     */
    /**
     * @var null
     */
    /**
     * @var null
     */
    /**
     * @var null
     */
    private $iDayAbb = null, $iShortDay = null, $iShortMonth = null, $iMonthName = null;

    /**
     * DateLocale constructor.
     */
    public function __construct()
    {
        settype($this->iDayAbb, 'array');
        settype($this->iShortDay, 'array');
        settype($this->iShortMonth, 'array');
        settype($this->iMonthName, 'array');
        $this->Set('C');
    }

    /**
     * @param $aLocale
     * @return bool
     * @throws JpGraphExceptionL
     */
    public function Set($aLocale)
    {
        if (in_array($aLocale, array_keys($this->iDayAbb))) {
            $this->iLocale = $aLocale;
            return TRUE;  // already cached nothing else to do!
        }

        $pLocale = setlocale(LC_TIME, 0); // get current locale for LC_TIME

        if (is_array($aLocale)) {
            foreach ($aLocale as $loc) {
                $res = @setlocale(LC_TIME, $loc);
                if ($res) {
                    $aLocale = $loc;
                    break;
                }
            }
        } else {
            $res = @setlocale(LC_TIME, $aLocale);
        }

        if (!$res) {
            JpGraphError::RaiseL(25007, $aLocale);
            //("You are trying to use the locale ($aLocale) which your PHP installation does not support. Hint: Use '' to indicate the default locale for this geographic region.");
            return FALSE;
        }

        $this->iLocale = $aLocale;
        for ($i = 0, $ofs = 0 - strftime('%w'); $i < 7; $i++, $ofs++) {
            $day = strftime('%a', strtotime("$ofs day"));
            $day[0] = strtoupper($day[0]);
            $this->iDayAbb[$aLocale][] = $day[0];
            $this->iShortDay[$aLocale][] = $day;
        }

        for ($i = 1; $i <= 12; ++$i) {
            list($short, $full) = explode('|', strftime("%b|%B", strtotime("2001-$i-01")));
            $this->iShortMonth[$aLocale][] = ucfirst($short);
            $this->iMonthName [$aLocale][] = ucfirst($full);
        }

        setlocale(LC_TIME, $pLocale);

        return TRUE;
    }


    /**
     * @return mixed
     */
    public function GetDayAbb()
    {
        return $this->iDayAbb[$this->iLocale];
    }

    /**
     * @return mixed
     */
    public function GetShortDay()
    {
        return $this->iShortDay[$this->iLocale];
    }

    /**
     * @return mixed
     */
    public function GetShortMonth()
    {
        return $this->iShortMonth[$this->iLocale];
    }

    /**
     * @param $aNbr
     * @return mixed
     */
    public function GetShortMonthName($aNbr)
    {
        return $this->iShortMonth[$this->iLocale][$aNbr];
    }

    /**
     * @param $aNbr
     * @return mixed
     */
    public function GetLongMonthName($aNbr)
    {
        return $this->iMonthName[$this->iLocale][$aNbr];
    }

    /**
     * @return mixed
     */
    public function GetMonth()
    {
        return $this->iMonthName[$this->iLocale];
    }
}