<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class KidsPayInstalacao{
  public static function get_simp_tables_names(){
    $tabelas = array(
      "clientes",
      "docs",
      "cidades",
      "ceps",
      "estados");

    return $tabelas;
  }

  public static function pegar_warnings(){
    global $wpdb;
    return $wpdb->get_results('SHOW WARNINGS;');
  }

  public static function esconder_warnings(){
    global $wpdb;
    $wpdb->query('SET sql_notes = 0;');
  }

  public static function mostrar_warnings(){
    global $wpdb;
    $wpdb->query('SET sql_notes = 1;');
  }

  public static function get_pref_tables_names(){
    global $wpdb;
    $tabelas = array(
      "{$wpdb->prefix}clientes",
      "{$wpdb->prefix}docs",
      "{$wpdb->prefix}cidades",
      "{$wpdb->prefix}ceps",
      "{$wpdb->prefix}estados");

    return $tabelas;
  }

  public static function get_schemas($tabela_name){
    global $wpdb;
    $tabelas = array('clientes' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}clientes(
        id int primary key auto_increment,
        nome varchar(300) not null);",

      'docs' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}docs(
        id int primary key,
        tipo int,
        num int);",

      'cidades' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cidades (
        id_cidade int(11) NOT NULL AUTO_INCREMENT,
        descricao varchar(100) DEFAULT '',
        uf varchar(2)  DEFAULT '',
        codigo_ibge int(11)  DEFAULT 0,
        ddd varchar(2)  DEFAULT '',
        PRIMARY KEY (id_cidade),
        KEY id (id_cidade) USING BTREE,
        KEY cidade (id_cidade,
        uf) USING BTREE,
        KEY cidade_estado (uf) USING BTREE);",

      'estados' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}estados(
        code INT PRIMARY KEY AUTO_INCREMENT,
        sigla varchar(5) not null default 'UF',
        nome varchar(100) not null default 'Estado');",

      'ceps' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}ceps (
        CEP varchar(11) NOT NULL,
        id_logradouro int(10) unsigned NOT NULL AUTO_INCREMENT,
        tipo varchar(50) DEFAULT '',
        descricao varchar(100)  DEFAULT '',
        id_cidade int(11)  DEFAULT 0,
        UF varchar(2)  DEFAULT '',
        complemento varchar(100) DEFAULT '',
        descricao_sem_numero varchar(100) DEFAULT '',
        descricao_cidade varchar(100) DEFAULT '',
        codigo_cidade_ibge int(11) DEFAULT 0,
        descricao_bairro varchar(100) DEFAULT '',
        PRIMARY KEY (id_logradouro),
        KEY cep (CEP) USING BTREE,
        KEY cidade (id_cidade, UF) USING BTREE,
        CONSTRAINT FK_cidade_2 FOREIGN KEY (id_cidade) REFERENCES {$wpdb->prefix}cidades (id_cidade));");

    return $tabelas[$tabela_name];

  }

  public function criar_tabelas(){
    global $wpdb;
    $tabelas = $this->get_simp_tables_names();

    foreach($tabelas as $tabela){
      $wpdb->query($this->get_schemas($tabela));
    }
  }

  public function instalar(){
    $this->criar_tabelas();
  }
}
