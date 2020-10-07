<?php

/**
 * Class RadarGrid
 */
class RadarGrid
{ //extends Grid {
    /**
     * @var string
     */
    private $type = 'solid';
    /**
     * @var string
     */
    private $grid_color = '#DDDDDD';
    /**
     * @var bool
     */
    /**
     * @var bool
     */
    private $show = false, $weight = 1;

    /**
     * RadarGrid constructor.
     */
    public function __construct()
    {
        // Empty
    }

    /**
     * @param $aMajColor
     */
    public function SetColor($aMajColor)
    {
        $this->grid_color = $aMajColor;
    }

    /**
     * @param $aWeight
     */
    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    // Specify if grid should be dashed, dotted or solid

    /**
     * @param $aType
     */
    public function SetLineStyle($aType)
    {
        $this->type = $aType;
    }

    // Decide if both major and minor grid should be displayed

    /**
     * @param bool $aShowMajor
     */
    public function Show($aShowMajor = true)
    {
        $this->show = $aShowMajor;
    }

    /**
     * @param $img
     * @param $grid
     */
    public function Stroke($img, $grid)
    {
        if (!$this->show) {
            return;
        }

        $nbrticks = count($grid[0]) / 2;
        $nbrpnts = count($grid);
        $img->SetColor($this->grid_color);
        $img->SetLineWeight($this->weight);

        for ($i = 0; $i < $nbrticks; ++$i) {
            for ($j = 0; $j < $nbrpnts; ++$j) {
                $pnts[$j * 2] = $grid[$j][$i * 2];
                $pnts[$j * 2 + 1] = $grid[$j][$i * 2 + 1];
            }
            for ($k = 0; $k < $nbrpnts; ++$k) {
                $l = ($k + 1) % $nbrpnts;
                if ($this->type == 'solid')
                    $img->Line($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1]);
                elseif ($this->type == 'dotted')
                    $img->DashedLine($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1], 1, 6);
                elseif ($this->type == 'dashed')
                    $img->DashedLine($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1], 2, 4);
                elseif ($this->type == 'longdashed')
                    $img->DashedLine($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1], 8, 6);
            }
            $pnts = array();
        }
    }
} 