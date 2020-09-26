<?php

class KidsPayElems{

  public $table = '';
  public $lista = array();
  public $form;

  public function noneOptions(){
    ?>
    <select>
      <option value='vazio'> Nenhuma Cadastrada </option>
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

  public function Options_display(){
    $options = $this->lista;

    if(!count($options)){
      $this->noneOptions();
    }else{
      echo "<select>";
      foreach ($options as $list) {
        echo "<option value='{$list['nome']}'> {$list['nome']} </option>";
      }
      echo "</select>";
    }

  }
}

?>
