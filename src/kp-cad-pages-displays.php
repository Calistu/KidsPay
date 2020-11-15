<?php


function kidspay_default_cad_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Informações Cadastrais</h1>
    <hr class='wp-head-end'>
    <?php
    $cliente = new KidsPayClientes();
    $cliente->display_cad_form();
    ?>
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
  global $wpdb;


  if(isset($_REQUEST['selecionar']) or isset($_REQUEST['confirmar'])){
    $form = new KidsPayForms();

    if(isset($_REQUEST['aluno']) and $_REQUEST['aluno'] !== 'vazio')
      $aluno = $_REQUEST['aluno'];
    else{
      $form->PrintOk("Selecione o aluno");
      $aluno = 'vazio';
    }

    if(isset($_REQUEST['produto']) and $_REQUEST['produto'] !== 'vazio')
      $produto = $_REQUEST['produto'];
    else{
      $form->PrintOk("Selecione o produto");
      $produto = 'vazio';
    }

    if(isset($_REQUEST['descricao']))
      $descricao = $_REQUEST['descricao'];
    else{
      $descricao = '';
    }
    if(isset($_REQUEST['ativo']))
      $ativo = 1;
    else
      $ativo = 0;

    if(isset($_REQUEST['confirmar'])){
      $res = $wpdb->get_results("SELECT * FROM restricoes_produtos WHERE id_aluno = {$aluno} and id_produto = {$produto} and id_cliente = " . get_current_user_id());
      if(!$res){
        $res = $wpdb->insert("restricoes_produtos", array('id_aluno' => $aluno, 'id_produto' => $produto, 'ativo'=> $ativo, 'id_cliente' => get_current_user_id(), 'descricao'=> $descricao));
        if(!$res){
          $form->Print("Não foi possível inserir restrição");
        }else{
          $form->PrintOk("Restrição criada com sucesso");
        }
      }else{
        $res = $wpdb->update("restricoes_produtos", array('descricao' => $descricao, 'ativo'=> $ativo), array('id_aluno' => $aluno, 'id_produto' => $produto, 'id_cliente' => get_current_user_id()));
        if(!$res){
          $res = $wpdb->get_results("SHOW ERRORS");
          if(!$res){
            $form->Print("Nada Atualizado");
          }else{
            $form->Print("Não foi possível atualizar");
          }
        }else{
          $form->PrintOk("Atualizado com sucesso");
        }

      }
    }

    if(isset($_REQUEST['selecionar'])){
      if($aluno !== 'vazio' && $produto !== 'vazio'){
        $res = $wpdb->get_results("SELECT id_aluno, id_produto, descricao, ativo FROM restricoes_produtos WHERE id_aluno = {$aluno} and id_produto = {$produto} and id_cliente = " . get_current_user_id(), ARRAY_A);
        if($res){
          foreach ($res as $key => $value) {
            $_REQUEST['aluno'] = $value['id_aluno'];
            $_REQUEST['produto'] = $value['id_produto'];
            $_REQUEST['descricao'] = $value['descricao'];
            $_REQUEST['ativo'] = $value['ativo'];
            $_REQUEST['existe'] = 1;
          }
        }else{
          $_REQUEST['descricao'] = '';
          $_REQUEST['ativo'] = 0;
          $_REQUEST['existe'] = 0;
        }
      }
    }
  }

  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Restrições</h1>
    <hr class='wp-head-end'>
  </div>
  <form action='?page=kidspay-cad-restricoes' method='post'>
  <?php
  $restricao = new KPRestricoes();
  $restricao->get_html_form();
  ?>
  </form>
  <?php
}

function kidspay_produtos_cad_page_display(){
  $acao = '';
  $form = new KidsPayForms();

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
