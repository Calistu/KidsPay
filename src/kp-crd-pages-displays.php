<?php
function kidspay_creditos_cmp_page_display(){
  if(isset($_REQUEST['atualizando'])){
    global $wpdb;
    $cliente = new KidsPayClientes();
    if(isset($_REQUEST['alunos'])){
      if($aluno = $cliente->get_alunoid_pnome($_REQUEST['alunos'])){
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
      }else{

      }
    }
  }
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Recarregar Créditos</h1>
    <hr class='wp-head-end'>
    <form action='?page=kidspay-crd-comprar' method="post">

    <?php
    comprar_creditos_html();
    ?>
    </form>
  <?php
}


function kidspay_creditos_estorno_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Recarregar Créditos</h1>
    <hr class='wp-head-end'>
    <form action='?page=kidspay-crd-comprar' method="post">
    <?php

    ?>
    </form>
    <?php
}
