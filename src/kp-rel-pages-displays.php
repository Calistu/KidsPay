<?php

function kidspay_default_rel_page_display(){
  echo "
  <link rel='stylesheets' href='{}';>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>KidsPay</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}

function kidspay_compras_itens(){

}

function kidspay_compras_rel_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Compras</h1>
    <hr class='wp-head-end'>
    <?php
    $compras = new KPComprasList();
    $compras->prepare_items();
    $compras->display();
    ?>
    </div>
    <?php
}

function kidspay_restricoes_rel_page_display(){
  if ( ! class_exists( 'WP_List_Table' ) ) {
	   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }

  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Restrições</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}


function kidspay_clientes_rel_page_display(){
  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Clientes</h1>
    <hr class='wp-head-end'>";
    $compras = new KPClientesList();
    $compras->prepare_items();
    $compras->display();
  "</div>
  ";
}


function kidspay_produtos_rel_page_display(){
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Produtos</h1>
    <hr class='wp-head-end' id='prod-list'>
    <?php
    $acao = '';
    global $wpdb;
    if(isset($_REQUEST['action']))
      $acao = $_REQUEST['action'];
    $form = new KidsPayForms();
    switch ($acao) {
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
