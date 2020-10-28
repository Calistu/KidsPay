<?php

if( !defined('ABSPATH')){
  die(ERRO_ABSPATH);
}

class KidsPayDB{
  public $prefix;
}

global $kpdb;
$kpdb = new KidsPayDB();
$kpdb->prefix = 'kidspay_';

require_once __DIR__ . '/LoadKidsPay.php';

Class KidsPayPlugin{
  public static function ativar(){
    $instalacao = new KidsPayInstalacao();
    //...
  }

  public static function desativar(){
    //$desativacao = new KidsPayDesinstalacao();
    //...
  }

  public static function desinstalar(){
    //$desinstalacao = new KidsPayDesinstalacao();
    //...
  }
}

function registrar_login(){
  global $wpdb;
  $cliente = new KidsPayClientes();
  if( !$cliente->get_loginid() ){
    $cliente->insert_loginid();
  }
}

function registrar_cadastros(){
  add_menu_page('KidsPay', 'Cadastros', 'read', 'kidspay-cad-tools', 'kidspay_produtos_cad_page_display', 'dashicons-food', 30);
  add_submenu_page('kidspay-cad-tools', 'Produtos', 'Produtos', 'read', 'kidspay-cad-produtos', 'kidspay_produtos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Alunos', 'Alunos', 'read', 'kidspay-cad-alunos', 'kidspay_alunos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Promoções', 'Promoções', 'manage_options', 'kidspay-cad-prodsem', 'kidspay_prod_semanal_cad_page_display');

}

function registrar_relatorios(){
  add_menu_page('KidsPay', 'Relatórios', 'read', 'kidspay-rel-tools', 'kidspay_compras_rel_page_display', 'dashicons-media-text', 30);
  add_submenu_page('kidspay-rel-tools', 'Compras', 'Compras', 'read', 'kidspay-rel-compras', 'kidspay_compras_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Clientes', 'Clientes', 'manage_options', 'kidspay-rel-clientes', 'kidspay_clientes_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Produtos', 'Produtos', 'manage_options', 'kidspay-rel-produtos', 'kidspay_produtos_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Restrições', 'Restrições', 'read', 'kidspay-rel-restricoes', 'kidspay_restricoes_rel_page_display');
}

function registrar_creditos(){
  add_menu_page('KidsPay', 'Créditos', 'read', 'kidspay-crd-comprar', 'kidspay_creditos_cmp_page_display', 'dashicons-cart', 30);
  add_submenu_page('kidspay-crd-comprar', 'Estornar', 'Estornar', 'read', 'kidspay-crd-estorno', 'kidspay_creditos_estorno_page_display');
}


global $KidsPay;
$KidsPay = new KidsPayPlugin();

if(is_admin()){
  remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
}

add_action('admin_menu', 'registrar_login');
add_action('admin_menu', 'registrar_cadastros');
add_action('admin_menu', 'registrar_relatorios');
add_action('admin_menu', 'registrar_creditos');

register_activation_hook(KP_PLUGIN_FILE, array($KidsPay, 'ativar'));
register_deactivation_hook(KP_PLUGIN_FILE, array($KidsPay, 'desativar'));
register_uninstall_hook(KP_PLUGIN_FILE, array( 'desinstalar' ));
