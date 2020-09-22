<?php

function kidspay_default_cad_page_display(){

  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}

function kidspay_compras_cad_page_display(){
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
  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Produtos</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}

function kidspay_creditos_cad_page_display(){
  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Créditos</h1>
    <hr class='wp-head-end'>

  </div>
  ";
}
