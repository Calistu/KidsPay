<?php

if( !defined('ABSPATH')){
  die(ERRO_ABSPATH);
}

require_once __DIR__ . '/LoadKidsPay.php';

Class KidsPayPlugin{
  public static function ativar(){
    $instalacao = new KidsPayInstalacao();
    $instalacao->criar_tabelas();
  }

  public static function desativar(){
  //  $desativacao = new KidsPayDesinstalacao();
  //  $desativacao->desinstalar();
  }

  public static function desinstalar(){
    $desinstalacao = new KidsPayDesinstalacao();
    $desinstalacao->desinstalar();
  }
}

function registrar_menu(){
  add_menu_page('KidsPay', 'KidsPay', 'read', 'kidspay-tools', 'kidspay_default_menu_page_display', 'dashicons-food', 30);
  add_submenu_page('kidspay-tools', 'Compras', 'Compras', 'read', 'kidspay-compras', 'kidspay_compras_menu_page_display');
  add_submenu_page('kidspay-tools', 'Produtos', 'Produtos', 'read', 'kidspay-produtos', 'kidspay_produtos_menu_page_display');
  add_submenu_page('kidspay-tools', 'Restrições', 'Restrições', 'read', 'kidspay-restricoes', 'kidspay_restricoes_menu_page_display');
  add_submenu_page('kidspay-tools', 'Créditos', 'Créditos', 'read', 'kidspay-creditos', 'kidspay_creditos_menu_page_display');
}

global $KidsPay;
$KidsPay = new KidsPayPlugin();

add_action('admin_menu', 'registrar_menu');

register_activation_hook(KP_PLUGIN_FILE, array($KidsPay, 'ativar'));
register_deactivation_hook(KP_PLUGIN_FILE, array($KidsPay, 'desativar'));
register_uninstall_hook(KP_PLUGIN_FILE, array( 'desinstalar' ));
