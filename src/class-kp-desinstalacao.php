<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class KidsPayDesinstalacao{


  public static function esconder_warnings(){
    global $wpdb;
    $wpdb->query('SET sql_notes = 0;');
  }

  public static function mostrar_warnings(){
    global $wpdb;
    $wpdb->query('SET sql_notes = 1;');
  }

  public static function get_simp_tables_names(){
    $tabelas = array(
      "clientes",
      "docs",
      "cidades",
      "ceps",
      "estados");

    return $tabelas;
  }

  public function get_pref_tables_names(){
    global $wpdb;
    $tabelas = array(
      'clientes' => "{$wpdb->prefix}clientes",
      'docs' => "{$wpdb->prefix}docs",
      'cidades' => "{$wpdb->prefix}cidades",
      'ceps' => "{$wpdb->prefix}ceps",
      'estados' => "{$wpdb->prefix}estados");

    $tabela = $this->get_simp_tables_names();
    $key = 0;

    foreach ($tabelas as $tabela[$key] => $tabela[$key]) {
      $key++;
    }

    return $tabelas;
  }

  public function get_schemas($tabela_name){
    global $wpdb;

    $tabelas = "DROP TABLE IF EXISTS {$this->get_pref_tables_names()[$tabela_name]}" ;

    return $tabelas;

  }

  public function deletar_tabelas($tabelas = null){
    global $wpdb;
    $this->esconder_warnings();

    if(!$tabelas)
      $tabelas = $this->get_simp_tables_names();

    foreach($tabelas as $tabela){
      $wpdb->query($this->get_schemas($tabela));
    }

    $this->mostrar_warnings();
  }

  public function desinstalar(){
    $this->deletar_tabelas();
  }
}

register_activation_hook( __FILE__, 'criar_tabelas' );
