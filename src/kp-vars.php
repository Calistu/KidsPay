<?php

global $meses;
$meses = array(
  1 => __("January"),
  2 => __("February"),
  3 => __("March"),
  4 => __("April"),
  5 => __("May"),
  6 => __("June"),
  7 => __("July"),
  8 => __("August"),
  9 => __("September"),
  10 => __("October"),
  11 => __("November"),
  12 => __("December"),
);

global $dias;
$dias = array(
  1 => __("Monday"),
  2 => __("Tuesday"),
  3 => __("Wednesday"),
  4 => __("Thursday"),
  5 => __("Friday"),
);


static $WFISC_CONFIGPAGE_CSS = KPPATH . 'config-admin-page.css';
static $WFISC_TOOLSPAGE_CSS = KPPATH . 'tools-admin-page.css';

define('ERRO_ABSPATH','Não foi possível carregar plugin KidsPay');
