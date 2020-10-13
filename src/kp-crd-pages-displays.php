<?php

function kidspay_creditos_cmp_page_display(){
  if(isset($_REQUEST['atualizando'])){
    global $wpdb;
    $cliente = new KidsPayClientes();
    if(isset($_REQUEST['atualizando'])){
      if(isset($_REQUEST['aluno'])){
        $aluno = $_REQUEST['aluno'];
        if(isset($_REQUEST['valor'])){
          if(!$_REQUEST['valor']){
            $cliente->PrintErro('Valor inválido');
          }else{
            $res = $wpdb->insert('credito_clientes', array(
              'dtpagamento' => date('Y-m-d'),
              'valor' => $_REQUEST['valor'],
              'situacao' => 'A',
              'id_cliente' =>  get_current_user_id(),
              'id_aluno' => $aluno
            ));
            if(!$res){
              die($wpdb->print_error());
            }else{
              $cliente->PrintOk('Recarregado com sucesso');
            }
          }
        }
      }else{
        $cliente->PrintErro('Não foi possível identificar aluno');
      }
    }
  }
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Recarregar Créditos</h1>
    <hr class='wp-head-end'>

    <?php
      comprar_creditos_html();
    ?>
  <?php
}


function kidspay_creditos_estorno_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Estornar Créditos</h1>
    <hr class='wp-head-end'>
    <form action='?page=kidspay-crd-estorno' method="post">

    <?php
      estornar_creditos_html();
    ?>
    </form>
    <?php
}
