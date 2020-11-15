<?php

function registrar_cadastros(){
  add_menu_page('KidsPay', 'Cadastros', KIDSPAY_CLI, 'kidspay-cad-tools', 'kidspay_default_cad_page_display', 'dashicons-food', 30);
  add_submenu_page('kidspay-cad-tools', 'Produtos', 'Produtos', KIDSPAY_ADMIN, 'kidspay-cad-produtos', 'kidspay_produtos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Alunos', 'Alunos', KIDSPAY_CLI, 'kidspay-cad-alunos', 'kidspay_alunos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Promoções', 'Promoções', KIDSPAY_ADMIN, 'kidspay-cad-prodsem', 'kidspay_prod_semanal_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Restrições', 'Restrições', KIDSPAY_CLI, 'kidspay-cad-restricoes', 'kidspay_restricoes_cad_page_display');

}

function registrar_relatorios(){

  global $kp_notif;
  $kp_notif->get_notifs();
  $notif_vendas = $kp_notif->relat['restricao']['qnt']+$kp_notif->relat['compras']['qnt'];

  add_menu_page('KidsPay', 'Relatórios' . $kp_notif->notif_bubble($notif_vendas), 'read', 'kidspay-rel-tools', 'kidspay_compras_rel_page_display', 'dashicons-media-text', 40);
  add_submenu_page('kidspay-rel-tools', 'Compras', 'Compras', KIDSPAY_CLI, 'kidspay-rel-tools', 'kidspay_compras_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Clientes', 'Clientes', KIDSPAY_ADMIN, 'kidspay-rel-clientes', 'kidspay_clientes_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Produtos', 'Produtos', KIDSPAY_CLI, 'kidspay-rel-produtos', 'kidspay_produtos_rel_page_display');
  add_submenu_page('kidspay-rel-tools', "Restrições", "Restrições", KIDSPAY_CLI, 'kidspay-rel-restricoes', 'kidspay_restricoes_rel_page_display');
}

function registrar_creditos(){

  global $kp_notif;
  $kp_notif->get_notifs();
  $notif_saldo = $kp_notif->relat['saldo_zerado']['qnt'];
  $notif_estorno = $kp_notif->relat['estorno']['qnt'];

  $notif_creditos = $notif_saldo + $notif_estorno;

  add_menu_page('KidsPay', 'Créditos' . $kp_notif->notif_bubble($notif_creditos), 'read', 'kidspay-crd-comprar' , 'kidspay_creditos_cmp_page_display', 'dashicons-cart', 50);
  add_submenu_page('kidspay-crd-comprar', 'Recarregar', 'Recarregar', KIDSPAY_CLI, 'kidspay-crd-comprar', 'kidspay_creditos_cmp_page_display');
  add_submenu_page('kidspay-crd-comprar', 'Estornar', 'Estornar' , KIDSPAY_CLI, 'kidspay-crd-estorno', 'kidspay_creditos_estorno_page_display');
}

function registrar_ferramentas(){
  add_menu_page('KidsPay', 'Download PDV', KIDSPAY_ADMIN, 'kidspay-crd-pdv' , 'kidspay_creditos_pdvdownload_page_display', 'dashicons-download', 54);
}
