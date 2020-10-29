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
  global $usuario_atual;
  $usuario_atual = new KidsPayClientes();

  if( !$usuario_atual->get_loginid() ){
    $usuario_atual->insert_loginid();
  }
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
