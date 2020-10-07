<?php

function kidspay_default_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros</h1>
    <hr class='wp-head-end'>
  </div>
  <?php
}

function kidspay_restricoes_cad_page_display(){
  if ( ! class_exists( 'WP_List_Table' ) ) {
	   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }
  ?>

  <div class='wrap'>
    <h1 class='wp-heading-inline'>Restrições</h1>
    <hr class='wp-head-end'>
  </div>

  <?php
}

function kidspay_produtos_cad_page_display(){
  $acao = '';

  global $wpdb;
  $produto = new KidsPayProdutos();
  $acao = $_REQUEST['action'];
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros Produtos</h1>
    <hr class='wp-head-end'>
    <form action='?page=kidspay-cad-produtos' method='post'>
    <?php

      cadastrar_produtos_html($acao);

      switch ($acao) {
        case 'cad':
          $res = $wpdb->insert('produtos',array(

            'nome' => $_REQUEST['nome'],
            'descricao' => $_REQUEST['descricao'],
            'preco_custo' => $_REQUEST['preco_custo'],
            'preco_venda' => $_REQUEST['preco_venda'],
            'situacao' => $_REQUEST['situacao'],
            )
          );
          if( !$res ){
            if($wpdb->print_error()){
              die($wpdb->print_error());
            }
          }else{
            $form = new KidsPayForms();
            $form->PrintOk('Cadastrado com Sucesso!');
          }
          break;
        case 'alt':

          break;
        case 'del':

          break;
      }
    ?>
    </form>
  </div>
  <?php
}

function kidspay_clientes_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Clientes</h1>
    <hr class='wp-head-end'>
  <?php
  /*-------------------------------------------------------------------*/
    $cliente = new KidsPayClientes();

    cadastrar_cliente_html();
  /*-------------------------------------------------------------------*/
  ?>
  </div>
  <?php
}

function kidspay_creditos_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Créditos</h1>
    <hr class='wp-head-end'>
  <?php
  /*-------------------------------------------------------------------*/


  /*-------------------------------------------------------------------*/
  ?>
  </div>
  <?php
}

function kidspay_alunos_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Alunos</h1>
    <hr class='wp-head-end'>
    <form action='?page=kidspay-cad-alunos' method='post'>
  <?php
  global $wpdb;
  $acao = $_REQUEST['action'];
  $form = new KidsPayForms();

  switch ($acao) {
    case 'cad':
    if(!isset($_REQUEST['nome'])){
      $form->PrintErro("Insira o nome");
    }else{
      $cliente = new KidsPayClientes();
      $res = $wpdb->insert('alunos',array(
        'nome' => $_REQUEST['nome'],
        'id_cliente' => $cliente->get_loginid()
        )
      );
      if( !$res ){
        if($wpdb->print_error()){
          $form->PrintErro($wpdb->print_error());
        }
      }else{
        $form = new KidsPayForms();
        $form->PrintOk('Cadastrado com Sucesso!');
      }
    }
      break;
    case 'alt':

      break;
    case 'del':

      break;
  }

  /*-------------------------------------------------------------------*/
  cadastrar_alunos_html('cad');
  /*-------------------------------------------------------------------*/
  ?>
  </form>
  </div>
  <?php
}
