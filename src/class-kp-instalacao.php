<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class KidsPayInstalacao{
  public static function get_simp_tables_names(){
    $tabelas = array(
      "status",
      "bancos",
      "tipo_movs",
      "conds_pag",
      "status",
      "clientes",
      "unidades",
      "prod_grupo",
      "produtos",
      "estoques",
      "pedidos",
      "movimentos",
      "cidades",
      "ceps",
      "estados"
      );

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

  public static function get_schemas($tabela_name){
    global $wpdb;
    $tabelas = array('clientes' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}clientes(
        id int primary key auto_increment,
        nome varchar(300) not null,
        cnpj_cpf varchar(20),
        ie_rg varchar(20),
        tipo_pessoa int,
        cep varchar(15),
        endereco varchar(50),
        bairro varchar(30),
        cidade varchar(30),
        uf varchar(3),
        numrua int,
        cmplemt int);",

      'bancos' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}bancos(
        id int primary key auto_increment,
        nome varchar(100),
        conta varchar(30),
        tipoconta int(11),
        agencia varchar(10),
        nome_usuario varchar(200),
        documento varchar(30));",

      'conds_pag' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}conds_pag(
        id int primary key auto_increment,
        nome varchar(30),
        tipo int,
        dfixo_flag int,
        dfixo int,
        intervalo int,
        qnt_parc int );",

      'prod_grupo' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}prod_grupo(
        id int primary key auto_increment,
        nome varchar(20),
        pai int,
        nivel int);",

      'unidades' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}unidades(
        id int primary key auto_increment,
        nome varchar(50),
        sigla varchar(10),
        multiplo int(11),
        medida int(11));",

      'status' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}status(
        id int primary key auto_increment,
        nome varchar(20));",

      'tipo_movs' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tipo_movs(
        id int primary key auto_increment,
        nome varchar(20),
        ent_said int);",

      'produtos' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}produtos(
        id int primary key auto_increment,
        nome varchar(50),
        peso float,
        unidade int,
        grupo int,
        observacao varchar(500),
        foreign key (unidade) references {$wpdb->prefix}unidades(id),
        foreign key (grupo) references {$wpdb->prefix}prod_grupo(id));",

      'pedidos' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pedidos(
        id int primary key auto_increment,
        tipo int not null,
        cliente int not null,
        data datetime,
        cond_pag int not null,
        banco int not null,
        status int not null,
        foreign key(cliente) references {$wpdb->prefix}clientes(id),
        foreign key(cond_pag) references {$wpdb->prefix}conds_pag(id),
        foreign key(banco) references {$wpdb->prefix}bancos(id),
        foreign key(tipo) references {$wpdb->prefix}tipo_movs(id),
        foreign key(status) references {$wpdb->prefix}status(id));",

      'estoques' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}estoques(
        id int primary key auto_increment,
        nome varchar(20));",

      'movimentos' => "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}movimentos(
        id int primary key auto_increment,
        estoque int not null,
        pedido int not null,
        cliente int not null,
        produto int not null,
        data datetime,
        tipo int not null,
        foreign key(estoque) references {$wpdb->prefix}estoques(id),
        foreign key(cliente) references {$wpdb->prefix}clientes(id),
        foreign key(pedido) references {$wpdb->prefix}pedidos(id),
        foreign key(tipo) references {$wpdb->prefix}tipo_movs(id),
        foreign key(produto) references {$wpdb->prefix}produtos(id));",

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
    $querys = '';
    foreach($tabelas as $tabela){
      if(!$wpdb->query($this->get_schemas($tabela)))
        wp_die('Erro ao deletar tabela: ' . $tabela);
      $querys .= $this->get_schemas($tabela);
    }
    //die($querys);
  }

  public function instalar(){
    $this->criar_tabelas();
  }
}
