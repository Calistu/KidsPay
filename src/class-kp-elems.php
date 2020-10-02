<?php

class KidsPayForms{

  public $table = '';
  public $lista = array();
  public $form;

  public function noneOptions(){
    ?>
    <select>
      <option value='vazio'> Sem Cadastro</option>
    </select>
    <?php
  }

  public function form_display(){
    ?>
    <table class="form-table">
    <?php
    foreach ($this->form as $i => $form) {

      if(!isset($form['descr']))
        $form['descr'] = '';

      if(!isset($form['tipo']))
        $form['tipo'] = '';

      if(!isset($form['classe']))
        $form['classe'] = '';

      if(!isset($form['valor']))
        $form['valor'] = '';

      echo "
      <tr>
        <th scope='row'><label>{$form['descr']}</label></th>
        <td><input type='{$form['tipo']}' class='{$form['classe']}' id='{$form['descr']}' value='{$form['valor']}'></td>
      </tr>
      ";
    }
    ?>
    </table>
    <?php
  }

  public function getList(){
    global $wpdb;
    global $kpdb;
    $this->lista = $wpdb->get_results("SELECT * FROM {$kpdb->prefix}{$this->table};", ARRAY_A);
    return $this->lista;
  }

  public function Options_display($var = ''){
    $options = $this->lista;

    if(!count($options)){
      $this->noneOptions();
    }else{
      echo "<select name='$var'>";
      foreach ($options as $list) {
        echo "<option name='aluno-{$list['nome']}' value='{$list['nome']}'> {$list['nome']} </option>";
      }
      echo "</select>";
    }

  }

  //mensagem personalizada sem status
  function Print($msg) {
      ?>
      <div class="notice">
          <p><?php _e( $msg, 'kidspay' ); ?></p>
      </div>
      <?php
  }

  //mensagem personalizada de conclusão
  function PrintOk($msg) {
      ?>
      <div class="notice notice-success is-dismissible">
          <p><?php _e( $msg, 'kidspay' ); ?></p>
      </div>
      <?php
  }

  //mensagem personalizada de erro
  public function PrintErro($msg){
    ?>
     <div class="notice error my-acf-notice is-dismissible" >
        <p>
          <?php
            _e( $msg , 'kidspay' );
            $this->erro = 1;
          ?>
        </p>
    </div>
    <?php
  }
}

?>
