<?php

class KidsPayForms{

  public $table = '';
  public $lista = array();
  public $form;

  public function getList(){
    global $wpdb;
    global $kpdb;
    $this->lista = $wpdb->get_results("SELECT * FROM {$kpdb->prefix}{$this->table};", ARRAY_A);
    return $this->lista;
  }

  //mensagem personalizada sem status
  function Print($msg) {
      ?>
      <div class="notice">
          <p><?php _e( $msg ); ?></p>
      </div>
      <?php
  }

  //mensagem personalizada de atualizacao
  function PrintUpdate($msg) {
      ?>
      <div class="update-message notice inline notice-warning notice-alt">
          <p><?php _e( $msg ); ?></p>
      </div>
      <?php
  }

  //mensagem personalizada de conclusão
  function PrintOk($msg) {
      ?>
      <div class="notice notice-success is-dismissible">
          <p><?php _e( $msg ); ?></p>
      </div>
      <?php
  }

  //mensagem personalizada de erro
  public function PrintErro($msg){
    ?>
     <div class="notice error my-acf-notice is-dismissible" >
        <p>
          <?php
            _e( $msg );
            $this->erro = 1;
          ?>
        </p>
    </div>
    <?php
  }
}

?>
