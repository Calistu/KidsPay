<?php


// Provide a deterministic list of new colors whenever the getColor() method
// is called. Used to automatically set colors of plots.

/**
 * Class ColorFactory
 */
class ColorFactory
{

    /**
     * @var int
     */
    static private $iIdx = 0;

    /**
     * @var array
     */
    static private $iColorList = array(
        'black',
        'blue',
        'orange',
        'darkgreen',
        'red',
        'AntiqueWhite3',
        'aquamarine3',
        'azure4',
        'brown',
        'cadetblue3',
        'chartreuse4',
        'chocolate',
        'darkblue',
        'darkgoldenrod3',
        'darkorchid3',
        'darksalmon',
        'darkseagreen4',
        'deepskyblue2',
        'dodgerblue4',
        'gold3',
        'hotpink',
        'lawngreen',
        'lightcoral',
        'lightpink3',
        'lightseagreen',
        'lightslateblue',
        'mediumpurple',
        'olivedrab',
        'orangered1',
        'peru',
        'slategray',
        'yellow4',
        'springgreen2');
    /**
     * @var int
     */
    static private $iNum = 33;

    /**
     * @return mixed
     */
    public static function getColor()
    {
        if (ColorFactory::$iIdx >= ColorFactory::$iNum) {
            ColorFactory::$iIdx = 0;
        }

        return ColorFactory::$iColorList[ColorFactory::$iIdx++];
    }

}