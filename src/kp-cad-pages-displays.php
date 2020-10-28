<?php


function kidspay_default_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros</h1>
    <hr class='wp-head-end'>
  </div>

  <?php
}

function kidspay_prod_semanal_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Promoção Semanal</h1>
    <hr class='wp-head-end'>
    <?php
    $produtos = new KidsPayProdutos();
    $produtos->prod_semana_html_form();
    ?>
  </div>

  <?php
}

function kidspay_restricoes_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Restrições</h1>
    <hr class='wp-head-end'>
  </div>
  <?php
  $produtos = new KidsPayProdutos();
  $produtos->restricoes_html_form();
  ?>
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
    <form action='?page=kidspay-cad-produtos' method='post' enctype="multipart/form-data">
    <?php
      $id = '';
      $uploadOk = 1;
      $form = new KidsPayForms();
      switch ($acao) {
        case 'cad':

          if(isset($_REQUEST['situacao'])){
            $situacao = 'A';
            $_REQUEST['situacao'] = 'checked';
          }else{
            $situacao = 'I';
            $_REQUEST['situacao'] = '';
          }

          $_REQUEST['image_path'] = baixar_imagem('image_path');

          if(isset($_REQUEST['nome']) and !strlen($_REQUEST['nome']) ){
            $form->PrintErro("Insira um nome para o produto");
            break;
          }

          if(isset($_REQUEST['preco_venda']) and !strlen($_REQUEST['preco_venda']) ){
            $form->PrintErro("Insira um preço para o produto");
            break;
          }

          $form->Print("Cadastrando Novo");
          $res = $wpdb->get_results('select MAX(id_produto) from produtos',ARRAY_A);
          if($res){
            $_REQUEST['id'] = $res[0]['MAX(id_produto)'];
          }
          $res = $wpdb->insert('produtos',array(
            'nome' => $_REQUEST['nome'],
            'image_path' => $_REQUEST['image_path'],
            'descricao' => $_REQUEST['descricao'],
            'preco_custo' => $_REQUEST['preco_custo'],
            'preco_venda' => $_REQUEST['preco_venda'],
            'situacao' => $situacao,
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
            $_REQUEST['image_path'] = $res[0]['image_path'];
            $_REQUEST['descricao'] = $res[0]['descricao'];
            $_REQUEST['preco_custo'] = $res[0]['preco_custo'];
            $_REQUEST['preco_venda'] = $res[0]['preco_venda'];

            if($res[0]['situacao'] == 'A')
              $_REQUEST['situacao'] = 'checked';
            else
              $_REQUEST['situacao'] = '';

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

          if(isset($_REQUEST['situacao'])){
            $_REQUEST['situacao'] = 'checked';
            $situacao = 'A';
          }else{
            $_REQUEST['situacao'] = '';
            $situacao = 'I';
          }
          if( isset($_FILES['image_path']) and !isset($_REQUEST['image_path']) ){
              $_REQUEST['image_path'] = baixar_imagem('image_path');
              if(!$_REQUEST['image_path']){
                $res = $wpdb->get_results("SELECT image_path FROM produtos WHERE id_produto = {$id};", ARRAY_A);
                if($res){
                  $_REQUEST['image_path'] = $res[0]['image_path'];
                }
              }
          }else{
            $_REQUEST['image_path'] = '';
          }

          $res = $wpdb->update('produtos', array(
            'nome' => $_REQUEST['nome'],
            'descricao' => $_REQUEST['descricao'],
            'image_path' => $_REQUEST['image_path'],
            'preco_custo' => $_REQUEST['preco_custo'],
            'preco_venda' => $_REQUEST['preco_venda'],
            'situacao' => $situacao,
          ),array('id_produto' => $id));
          if($res){
            $form->PrintOk("Atualizado com sucesso");
            $acao = 'alt2';
          }else{
            if($wpdb->get_results('SHOW ERRORS')){
              if($wpdb->show_errors()){
                $wpdb->print_error();
              }
            }
            $form->PrintErro("Nenhuma informação atualizada");
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
          $form->Print("Cadastrando Novo");
          $acao = 'cad';
          break;
        default:
          $acao = 'cad';
          $form->Print("Cadastrando Novo");
      }
      $produtos = new KidsPayProdutos();
      $produtos->cadastrar_produtos_html($acao);
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
    $cliente->cadastrar_cliente_html();
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
  <?php

  global $wpdb;
  $acao = '';

  if(isset($_REQUEST['action']))
    $acao = $_REQUEST['action'];

  $form = new KidsPayForms();

  switch ($acao) {
    case 'Cadastrar':
      if(!isset($_REQUEST['nome'])){
        $form->PrintErro("Insira o nome");
      }else{
        if(!$wpdb->get_results("select * from alunos where id_cliente = " . get_current_user_id() . " and nome = '{$_REQUEST['nome']}'")){

          $cliente = new KidsPayClientes();
          $res = $wpdb->insert('alunos',array(
            'nome' => $_REQUEST['nome'],
            'id_cliente' => $cliente->get_loginid()
          ));
          if( !$res ){
            if($wpdb->print_error()){
              $form->PrintErro($wpdb->print_error());
            }
          }else{
            $form = new KidsPayForms();
            $form->PrintOk('Cadastrado com Sucesso!');
          }
        }else{
          $form->PrintErro('Aluno já existente!');
        }
      }
      break;

    case 'Atualizar':
      if(!isset($_REQUEST['nome'])){
        $form->PrintErro("Insira o nome");
      }else{
        if(isset($_REQUEST['id'])){
          $id = $_REQUEST['id'];
          $cliente = new KidsPayClientes();
          $res = $wpdb->get_results("select * from alunos where id_cliente = " . get_current_user_id() ." and nome = '{$_REQUEST['nome']}'", ARRAY_A);
          if(!$res){
            $res = $wpdb->update('alunos',
            array(
              'nome' => $_REQUEST['nome'],
              'id_cliente' => $cliente->get_loginid()
            ),
            array(
              'id_aluno' => $id
            )
            );
            if( !$res ){
              if($wpdb->print_error()){
                $form->PrintErro($wpdb->print_error());
              }
              $form->Print('Aluno não foi atualizado!');
            }else{
              $form = new KidsPayForms();
              $form->PrintOk('Atualizado com Sucesso!');
            }
          }else{
            $form->Print('Aluno não teve atualização!');
          }
        }else{
          $form->Print('Aluno já existe!');
        }
      }

      break;
    case 'Deletar':
      if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $cliente = new KidsPayClientes();
        $res = $wpdb->get_results("SELECT * FROM credito_clientes where id_aluno = ". $id);
        if($res){
          $form->Print("Aluno já possui movimentos de créditos");
          break;
        }
        $res = $wpdb->get_results("SELECT * FROM vendas where id_aluno = ". $id);
        if($res){
          $form->Print("Aluno já possui movimentos de compras");
          break;
        }
        $res = $wpdb->delete('alunos',
         array(
          'id_aluno' => $id
        ));
        if( !$res ){
          if($wpdb->print_error()){
            $form->PrintErro($wpdb->print_error());
          }
          $form->Print('Nenhum aluno deletado!');
        }else{
          $form = new KidsPayForms();
          $form->PrintOk('Deletado com Sucesso!');
        }
      }
      break;
  }
  /*-------------------------------------------------------------------*/
  $cliente = new KidsPayClientes();
  $cliente->cadastrar_alunos_html();
  /*-------------------------------------------------------------------*/
  ?>
  <script>
    <?php
    if(isset($_REQUEST['nome'])){
      ?>
      carrega_div('<?php echo "{$_REQUEST['nome']}" . "-button"; ?>');
      <?php
    }else{
      ?>
      carrega_div('defaultOpen');
    <?php
    }
    ?>
  </script>
  </div>
  <?php
}
