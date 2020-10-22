<?php

/**
 * Aqua Theme class
 */
class AquaTheme extends Theme
{
    /**
     * @var string
     */
    protected $font_color = '#0044CC';
    /**
     * @var string
     */
    protected $background_color = '#DDFFFF';
    /**
     * @var string
     */
    protected $axis_color = '#0066CC';
    /**
     * @var string
     */
    protected $grid_color = '#3366CC';

    /**
     * @return array
     */
    public function GetColorList()
    {
        return array(
            '#183152',
            '#C4D7ED',
            '#375D81',
            '#ABC8E2',
            '#E1E6FA',
            '#9BBAB2',
            '#3B4259',
            '#0063BC',
            '#1D5A73',
            '#ABABFF',
            '#27ADC5',
            '#EDFFCC',
        );
    }

    /**
     * @param $graph
     */
    public function SetupGraph($graph)
    {
        $graph->SetFrame(false);
        $graph->SetMarginColor('white');
        $graph->SetBackgroundGradient($this->background_color, '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

        // legend
        $graph->legend->SetFrameWeight(0);
        $graph->legend->Pos(0.5, 0.85, 'center', 'top');
        $graph->legend->SetFillColor('white');
        $graph->legend->SetLayout(LEGEND_HOR);
        $graph->legend->SetColumns(3);
        $graph->legend->SetShadow(false);
        $graph->legend->SetMarkAbsSize(5);

        // xaxis
        $graph->xaxis->title->SetColor($this->font_color);
        $graph->xaxis->SetColor($this->axis_color, $this->font_color);
        $graph->xaxis->SetTickSide(SIDE_BOTTOM);
        $graph->xaxis->SetLabelMargin(10);

        // yaxis
        $graph->yaxis->title->SetColor($this->font_color);
        $graph->yaxis->SetColor($this->axis_color, $this->font_color);
        $graph->yaxis->SetTickSide(SIDE_LEFT);
        $graph->yaxis->SetLabelMargin(8);
        $graph->yaxis->HideLine();
        $graph->yaxis->HideTicks();
        $graph->xaxis->SetTitleMargin(15);

        // grid
        $graph->ygrid->SetColor($this->grid_color);
        $graph->ygrid->SetLineStyle('dotted');


        // font
        $graph->title->SetColor($this->font_color);
        $graph->subtitle->SetColor($this->font_color);
        $graph->subsubtitle->SetColor($this->font_color);
    }


    /**
     * @param $graph
     */
    public function SetupPieGraph($graph)
    {

        // graph
        $graph->SetFrame(false);

        // legend
        $graph->legend->SetFillColor('white');

        $graph->legend->SetFrameWeight(0);
        $graph->legend->Pos(0.5, 0.80, 'center', 'top');
        $graph->legend->SetLayout(LEGEND_HOR);
        $graph->legend->SetColumns(4);

        $graph->legend->SetShadow(false);
        $graph->legend->SetMarkAbsSize(5);

        // title
        $graph->title->SetColor($this->font_color);
        $graph->subtitle->SetColor($this->font_color);
        $graph->subsubtitle->SetColor($this->font_color);

        $graph->SetAntiAliasing();
    }


    /**
     * @param $graph
     */
    public function PreStrokeApply($graph)
    {
        if ($graph->legend->HasItems()) {
            $img = $graph->img;
            $graph->SetMargin(
                $img->raw_left_margin,
                $img->raw_right_margin,
                $img->raw_top_margin,
                is_numeric($img->raw_bottom_margin) ? $img->raw_bottom_margin : $img->height * 0.25
            );
        }
    }

    /**
     * @param $plot
     */
    public function ApplyPlot($plot)
    {

        switch (get_class($plot)) {
            case 'GroupBarPlot':
                {
                    foreach ($plot->plots as $_plot) {
                        $this->ApplyPlot($_plot);
                    }
                    break;
                }

            case 'AccBarPlot':
                {
                    foreach ($plot->plots as $_plot) {
                        $this->ApplyPlot($_plot);
                    }
                    break;
                }

            case 'BarPlot':
                {
                    $plot->Clear();

                    $color = $this->GetNextColor();
                    $plot->SetColor($color);
                    $plot->SetFillColor($color);
                    //$plot->SetShadow();
                    break;
                }

            case 'LinePlot':
                {
                    $plot->Clear();
                    $plot->SetColor($this->GetNextColor());
                    $plot->SetWeight(2);
                    break;
                }

            case 'PiePlot':
                {
                    $plot->SetCenter(0.5, 0.45);
                    $plot->ShowBorder(false);
                    $plot->SetSliceColors($this->GetThemeColors());
                    break;
                }

            case 'PiePlot3D':
                {
                    $plot->SetSliceColors($this->GetThemeColors());
                    break;
                }
        }
    }
}
