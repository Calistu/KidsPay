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
      "ceps",
      "movimentos",
      "pedidos",
      "estoques",
      "clientes",
      "produtos",
      "prod_grupo",
      "unidades",
      "cidades",
      "estados",
      "conds_pag",
      "status",
      "tipo_movs",
      "bancos",
      "status"
      );
    return $tabelas;
  }

  public function get_pref_tables_names(){
    global $wpdb;
    $tabelas = array(
      'clientes' => "{$wpdb->prefix}clientes",
      'prod_grupo' => "{$wpdb->prefix}prod_grupo",
      'unidades' => "{$wpdb->prefix}unidades",
      'produtos' => "{$wpdb->prefix}produtos",
      'estoques' => "{$wpdb->prefix}estoques",
      'status' => "{$wpdb->prefix}status",
      'bancos' => "{$wpdb->prefix}bancos",
      'movimentos' => "{$wpdb->prefix}movimentos",
      'pedidos' => "{$wpdb->prefix}pedidos",
      'cidades' => "{$wpdb->prefix}cidades",
      'ceps' => "{$wpdb->prefix}ceps",
      'estados' => "{$wpdb->prefix}estados",
      'tipo_movs' => "{$wpdb->prefix}tipo_movs",
      'conds_pag' => "{$wpdb->prefix}conds_pag",
      'status' => "{$wpdb->prefix}status");

    $tabela = $this->get_simp_tables_names();
    $key = 0;

    foreach ($tabelas as $tabela[$key] => $tabela[$key]) {
      $key++;
    }

    return $tabelas;
  }

  public function get_schemas($tabela_name){
    global $wpdb;

    $tabelas = "DROP TABLE IF EXISTS {$this->get_pref_tables_names()[$tabela_name]};" ;

    return $tabelas;

  }

  public function deletar_tabelas($tabelas = null){
    global $wpdb;

    if(!$tabelas)
      $tabelas = $this->get_simp_tables_names();
    $querys = '';
    foreach($tabelas as $tabela){
      if(!$wpdb->query($this->get_schemas($tabela)))
        wp_die('Erro ao deletar tabela: ' . $tabela);
      //$querys .= $this->get_schemas($tabela)."<br>";
    }
    //die($querys);
  }

  public function desinstalar(){
    $this->deletar_tabelas();
  }
}

register_activation_hook( __FILE__, 'criar_tabelas' );
