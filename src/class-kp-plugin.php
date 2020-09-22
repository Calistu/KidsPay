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
    $desativacao = new KidsPayDesinstalacao();
    $desativacao->desinstalar();
  }

  public static function desinstalar(){
    $desinstalacao = new KidsPayDesinstalacao();
    $desinstalacao->desinstalar();
  }
}

function registrar_cadastros(){
  add_menu_page('KidsPay', 'Cadastros KidsPay', 'read', 'kidspay-cad-tools', 'kidspay_default_cad_page_display', 'dashicons-food', 30);
  add_submenu_page('kidspay-cad-tools', 'Produtos', 'Produtos', 'manage_options', 'kidspay-cad-produtos', 'kidspay_produtos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Restrições', 'Restrições', 'read', 'kidspay-cad-restricoes', 'kidspay_restricoes_cad_page_display');
}

function registrar_relatorios(){
  add_menu_page('KidsPay', 'Relatórios KidsPay', 'read', 'kidspay-rel-tools', 'kidspay_default_rel_page_display', 'dashicons-media-text', 30);
  add_submenu_page('kidspay-rel-tools', 'Compras', 'Compras', 'read', 'kidspay-rel-compras', 'kidspay_compras_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Clientes', 'Clientes', 'read', 'kidspay-rel-clientes', 'kidspay_clientes_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Produtos', 'Produtos', 'read', 'kidspay-rel-produtos', 'kidspay_produtos_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Restrições', 'Restrições', 'read', 'kidspay-rel-restricoes', 'kidspay_restricoes_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Créditos', 'Créditos', 'read', 'kidspay-rel-creditos', 'kidspay_creditos_rel_page_display');
}

global $KidsPay;
$KidsPay = new KidsPayPlugin();

add_action('admin_menu', 'registrar_cadastros');
add_action('admin_menu', 'registrar_relatorios');

register_activation_hook(KP_PLUGIN_FILE, array($KidsPay, 'ativar'));
register_deactivation_hook(KP_PLUGIN_FILE, array($KidsPay, 'desativar'));
register_uninstall_hook(KP_PLUGIN_FILE, array( 'desinstalar' ));
