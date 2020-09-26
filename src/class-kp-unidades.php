<?php

class KidsPayUnidades extends KidsPayElems{

  public $id = 0;
  public $nome = '';

  function __construct(){
    $this->table = 'unidades';
  }

}
?>
