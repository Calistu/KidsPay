<?php

if( !defined('ABSPATH')){
  die(ERRO_ABSPATH);
}

require_once __DIR__ . '/kp-vars.php';
require_once __DIR__ . '/class-kp-instalacao.php';
require_once __DIR__ . '/class-kp-desinstalacao.php';
require_once __DIR__ . '/class-kp-tools.php';
require_once __DIR__ . '/kp-default-menu-pages.php';

require_once __DIR__ . '/kp-cad-pages-displays.php';
require_once __DIR__ . '/kp-rel-pages-displays.php';

require_once __DIR__ . '/class-kp-elems.php';

require_once __DIR__ . '/class-kp-clientes.php';
require_once __DIR__ . '/class-kp-clientes-list.php';

require_once __DIR__ . '/class-kp-compras.php';
require_once __DIR__ . '/class-kp-compras-list.php';

require_once __DIR__ . '/class-kp-grupos.php';
require_once __DIR__ . '/class-kp-unidades.php';
require_once __DIR__ . '/class-kp-produtos.php';
require_once __DIR__ . '/class-kp-produtos-list.php';
require_once __DIR__ . '/class-kp-produtos_widgets.php';

require_once __DIR__ . '/class-kp-plugin.php';
