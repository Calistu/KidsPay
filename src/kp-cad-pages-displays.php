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
  if(isset($_REQUEST['action']))
    $acao = $_REQUEST['action'];

  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros Produtos</h1>
    <hr class='wp-head-end'>
    <form action='?page=kidspay-cad-produtos' method='post'>
    <?php

      $form = new KidsPayForms();
      switch ($acao) {
        case 'cad':
          $form->Print("Cadastrando Novo");
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
            $form->PrintOk('Cadastrado com Sucesso!');
            $acao = "alt";
          }
          break;
        case 'alt':
          $id = $_REQUEST['id'];
          $res = $wpdb->get_results("SELECT * FROM produtos WHERE id_produto = {$id};", ARRAY_A);
          if($res and $res[0]){
            $form->Print("Alterando produto cód.: {$id}");
            $_REQUEST['id_produto'] = $res[0]['id_produto'];
            $_REQUEST['nome'] = $res[0]['nome'];
            $_REQUEST['descricao'] = $res[0]['descricao'];
            $_REQUEST['preco_custo'] = $res[0]['preco_custo'];
            $_REQUEST['preco_venda'] = $res[0]['preco_venda'];
            $_REQUEST['situacao'] = $res[0]['situacao'];
            $acao = 'alt2';
          }else{
            $form->PrintErro("Não foi possível receber produto");
          }
          break;
        case 'alt2':
          $form->PrintOk("Atualizando...");
          if(isset($_REQUEST['id']))
            $id = $_REQUEST['id'];
          else{
            $form->PrintErro("Requisição invalida");
            break;
          }
          $res = $wpdb->update('produtos', array(
            'nome' => $_REQUEST['nome'],
            'descricao' => $_REQUEST['descricao'],
            'preco_custo' => $_REQUEST['preco_custo'],
            'preco_venda' => $_REQUEST['preco_venda'],
            'situacao' => $_REQUEST['situacao'],
          ),array('id_produto' => $id));
          if($res){
            $form->PrintOk("Atualizado com sucesso");
            $acao = 'alt';
          }else{
            $form->PrintErro("Não foi possível atualizar produto - {$wpdb->print_error()}");
          }
          break;
        case 'del':
          $id = $_REQUEST['id'];
          if(($wpdb->delete('produtos', array(
            'id_produto' => $id)
          ))){
            $form->PrintOk("Deletado com Sucesso");
          }else{
            $form->PrintOk("Nenhum produto deletado");
          }
          break;
        default:
          $acao = 'cad';
          $form->Print("Cadastrando Novo");
      }
      cadastrar_produtos_html($acao);
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
  $acao = '';

  if(isset($_REQUEST['action']))
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
