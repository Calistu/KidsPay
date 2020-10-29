<?php

class KidsPayNotif{

  public $relat;
  private $func;

  function __construct(){

    $this->relat = array(
      'compras' => array('qnt'=>0),
      'restricao' => array('qnt'=>0),
      'estorno' => array('qnt'=>0),
      'saldo_zerado' => array('qnt'=>0)
    );

  }

  public function get_notifs($id = ''){

    global $usuario_atual;
    global $wpdb;
    $form = new KidsPayForms();
    $where = '';
    if($id){
      $where = " and id_venda = {$id}";
    }
    foreach ($this->relat as $key => $value) {
      $this->relat[$key]['qnt'] = 0;
    }

    $notificoes = $wpdb->get_results("SELECT * FROM notificacoes WHERE visualizado = 0 $where and id_cliente = " . get_current_user_id(),ARRAY_A);
    if($notificoes){
      foreach ($notificoes as $key => $notificao) {
        foreach ($this->relat as $relatkey => $value) {
          if($relatkey == $notificao['tipo_notif']){
            $this->relat[$relatkey][$key] = $notificao;
            $this->relat[$relatkey]['qnt']++;
          }
        }
      }
    }
    return $notificoes;
  }

  public function clean_compras_notifs($id = ''){
    global $wpdb;

    $wpdb->update('notificacoes',
    array(
      'visualizado' => 1,
    ),array(
      'tipo_notif' => 'compras',
      'id_cliente' => get_current_user_id()
    ));
  }

  public function clean_restricao_notifs($id = ''){
    global $wpdb;
    $wpdb->update('notificacoes',
    array(
      'visualizado' => 1,
    ),array(
      'tipo_notif' => 'restricao',
      'id_cliente' => get_current_user_id()
    ));
  }

  public function clean_saldozerado_notifs($id = ''){
    global $wpdb;
    $wpdb->update('notificacoes',
    array(
      'visualizado' => 1,
    ),array(
      'tipo_notif' => 'estorno',
      'id_cliente' => get_current_user_id()
    ));
  }

  public function clean_estorno_notifs($id = ''){
    global $wpdb;
    $wpdb->update('notificacoes',
    array(
      'visualizado' => 1,
    ),array(
      'tipo_notif' => 'estorno',
      'id_cliente' => get_current_user_id()
    ));
  }


  public function notif_bubble($qnt = 0){
    if($qnt)
      return "<span class='awaiting-mod'>{$qnt}</span>";
  }

}

global $kp_notif;
$kp_notif = new KidsPayNotif();

?>
