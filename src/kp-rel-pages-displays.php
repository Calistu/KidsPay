<?php

function kidspay_default_rel_page_display(){
  ?>
  <link rel='stylesheets' href='{}';>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>KidsPay</h1>
    <hr class='wp-head-end'>

  </div>
  <?php
}

function kidspay_compras_itens(){

}

function kidspay_compras_rel_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Compras</h1>
    <hr class='wp-head-end'>
    <?php
    $form = new KidsPayForms();

    mostrar_grafico_vendas();

    global $kp_notif;
    if(isset($_REQUEST['visualizado'])){
      $kp_notif->clean_compras_notifs($_REQUEST['visualizado']);
    }

    $kp_notif->get_notifs();
    foreach ($kp_notif->relat['compras'] as $key => $value) {
      if($key !== 'qnt'){
        $form->PrintUpdate($value['descricao'] . " <a class='action' style='text-decoration: none;' href='?page=kidspay-rel-tools&visualizado={$value['id_notif']}'> Ok </a>");
      }
    }

    $compras = new KPComprasList();
    $compras->prepare_items();
    $compras->display();
    ?>
    </div>
    <?php
}

function kidspay_restricoes_rel_page_display(){

  global $wpdb;
  $form = new KidsPayForms();
  if(isset($_REQUEST['acao'])){
    $acao = $_REQUEST['acao'];
    if(isset($_REQUEST['id'])){
      $id = $_REQUEST['id'];
      switch ($acao) {
        case 'ativar':
          $res = $wpdb->update('restricoes_produtos',array('ativo'=>1), array('id_restricao' => $id, 'id_cliente' => get_current_user_id()));
          if($res){
            $form->PrintOk("Restrição Ativada");
          }
          break;
        case 'desativar':
          $res = $wpdb->update('restricoes_produtos',array('ativo'=>0), array('id_restricao' => $id, 'id_cliente' => get_current_user_id()));
          if($res){
            $form->PrintOk("Restrição Desativada");
          }
          break;
        case 'deletar':
          $res = $wpdb->delete('restricoes_produtos', array('id_restricao' => $id, 'id_cliente' => get_current_user_id()));
          if($res){
            $form->PrintOk("Restrição Deletada");
          }
          break;
      }
    }else{
      $form->PrintErro("Requisição incompleta");
    }
  }
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Restrições</h1>
    <hr class='wp-head-end'>
    <?php
    $restricoes_list = new KPRestricoesList();
    $restricoes_list->prepare_items();
    $restricoes_list->display();
    ?>
  </div>
  <?php
}


function kidspay_clientes_rel_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Clientes</h1>
    <hr class='wp-head-end'>";
    <?php
    mostrar_grafico_clientes();
    $compras = new KPClientesList();
    $compras->prepare_items();
    $compras->display();
    ?>
  </div>
  <?php
}


function kidspay_produtos_rel_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Produtos</h1>
    <hr class='wp-head-end' id='prod-list'>
    <?php
    global $wpdb;

    mostrar_grafico_produtos();
    $acao = '';
    if(isset($_REQUEST['action']))
      $acao = $_REQUEST['action'];
    $form = new KidsPayForms();
    switch ($acao) {
      case 'del':
        $id = $_REQUEST['id'];
        $exists = $wpdb->get_results("SELECT * FROM promocao_diaria WHERE id_produto = {$id} LIMIT 1");
        if($exists){
          $form->PrintErro("Produto postado para promoção, retire!");
          break;
        }
        $exists = $wpdb->get_results("SELECT * FROM item_vendas WHERE id_produto = {$id} LIMIT 1");
        if($exists){
          $form->PrintErro("Produto já usado para vendas, aconselhado inativar!");
          break;
        }

        if(($wpdb->delete('produtos', array(
          'id_produto' => $id)
        ))){
          $form->PrintOk("Deletado com Sucesso");
        }else{
          $form->PrintOk("Nenhum produto deletado");
        }
        break;
    }
    $produtos = new KPProdutosList();
    $produtos->prepare_items();
    ?>
    <form id='events-filter' method='get'>
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php
    $produtos->display();
    echo "</form>";
    ?>
  </div>
  <?php
}

function kidspay_creditos_rel_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Créditos</h1>
    <hr class='wp-head-end'>

  </div>
  <?php
}
