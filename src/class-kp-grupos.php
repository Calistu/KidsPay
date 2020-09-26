<?php

class KidsPayGrupos extends KidsPayElems{

  public $id = 0;
  public $nome = '';


  function __construct(){
    $this->table = 'prod_grupo';
  }
}

?>
