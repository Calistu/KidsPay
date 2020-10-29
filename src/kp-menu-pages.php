<?php

function registrar_cadastros(){
  add_menu_page('KidsPay', 'Cadastros', 'read', 'kidspay-cad-tools', 'kidspay_produtos_cad_page_display', 'dashicons-food', 30);
  add_submenu_page('kidspay-cad-tools', 'Produtos', 'Produtos', 'read', 'kidspay-cad-produtos', 'kidspay_produtos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Alunos', 'Alunos', 'read', 'kidspay-cad-alunos', 'kidspay_alunos_cad_page_display');
  add_submenu_page('kidspay-cad-tools', 'Promoções', 'Promoções', 'manage_options', 'kidspay-cad-prodsem', 'kidspay_prod_semanal_cad_page_display');

}

function registrar_relatorios(){

  global $kp_notif;
  $kp_notif->get_notifs();
  $notif_vendas = $kp_notif->relat['restricao']['qnt']+$kp_notif->relat['compras']['qnt'];

  add_menu_page('KidsPay', 'Analises' . $kp_notif->notif_bubble($notif_vendas), 'read', 'kidspay-rel-tools', 'kidspay_compras_rel_page_display', 'dashicons-media-text', 40);
  add_submenu_page('kidspay-rel-tools', 'Compras', 'Compras', 'read', 'kidspay-rel-tools', 'kidspay_compras_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Clientes', 'Clientes', 'manage_options', 'kidspay-rel-clientes', 'kidspay_clientes_rel_page_display');
  add_submenu_page('kidspay-rel-tools', 'Produtos', 'Produtos', 'manage_options', 'kidspay-rel-produtos', 'kidspay_produtos_rel_page_display');
  add_submenu_page('kidspay-rel-tools', "Restrições", "Restrições", 'read', 'kidspay-rel-restricoes', 'kidspay_restricoes_rel_page_display');
}

function registrar_creditos(){

  global $kp_notif;
  $kp_notif->get_notifs();
  $notif_saldo = $kp_notif->relat['saldo_zerado']['qnt'];
  $notif_estorno = $kp_notif->relat['estorno']['qnt'];

  $notif_creditos = $notif_saldo + $notif_estorno;

  add_menu_page('KidsPay', 'Créditos' . $kp_notif->notif_bubble($notif_creditos), 'read', 'kidspay-crd-comprar' , 'kidspay_creditos_cmp_page_display', 'dashicons-cart', 50);
  add_submenu_page('kidspay-crd-comprar', 'Recarregar', 'Recarregar', 'read', 'kidspay-crd-comprar', 'kidspay_creditos_cmp_page_display');
  add_submenu_page('kidspay-crd-comprar', 'Estornar', 'Estornar' , 'read', 'kidspay-crd-estorno', 'kidspay_creditos_estorno_page_display');
}
