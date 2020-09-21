<?php

function kidspay_default_menu_page_display(){
  echo "
  <link rel='stylesheets' href='{}';>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>KidsPay</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}

function kidspay_compras_menu_page_display(){
  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Compras</h1>
    <hr class='wp-head-end'>";
    $compras = new KPComprasList();
    $compras->prepare_items();
    $compras->display();

    if(!$compras->totalItems){
      echo $compras->no_items();
    }

    "</div>";
}

function kidspay_restricoes_menu_page_display(){
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

function kidspay_produtos_menu_page_display(){
  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Produtos</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}

function kidspay_creditos_menu_page_display(){
  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Créditos</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}
