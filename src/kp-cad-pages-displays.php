<?php

function kidspay_default_cad_page_display(){

  echo "
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros</h1>
    <hr class='wp-head-end'>
    Cadastros
  </div>
  ";
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
  ?>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Cadastros Produtos</h1>
    <hr class='wp-head-end'>

  <?php
    $produto = new KidsPayProdutos();
    $produto->cadform_display();
  ?>

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
    $cliente->getList();
    $cliente->form = array(

      '0' =>  array('descr' => 'Nome:',
        'tipo' => 'text',
        'classe' => 'regular_text'),

      '1' =>  array('descr' => 'RA - Criança:',
        'tipo' => 'text',
        'classe' => 'regular_text'),

      '2' =>  array('descr' => 'CPF:',
        'tipo' => 'text',
        'classe' => 'regular_text'),

      '3' =>  array('descr' => 'RG:',
        'tipo' => 'text',
        'classe' => 'regular_text'),

      '4' =>  array('descr' => 'CEP:',
        'tipo' => 'text',
        'classe' => 'regular_text'),

      '5' =>  array('descr' => 'Endereço:',
        'tipo' => 'text',
        'classe' => 'regular_text'),

      '6' => array('descr' => 'Telefone',
        'tipo' => 'tel',
        'classe' => 'regular_text'),

      '7' =>  array('descr' => 'Email',
        'tipo' => 'email'),

      '8' =>  array('descr' => 'Ativo?',
        'tipo' => 'checkbox'),

      '9' =>  array('descr' => '',
        'tipo' => 'submit',
        'classe' => 'button button-primary',
        'valor' => 'Enviar'));

    $cliente->form_display();
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
