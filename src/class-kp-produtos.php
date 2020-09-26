<?php

class KidsPayProdutos extends KidsPayElems{

  public $id = 0;
  public $nome = '';
  public $peso = 0.0;
  public $unidade = 0;
  public $grupo = 0;
  public $observacoes = '';

  public function cadform_display(){
    ?>
      <table action='kp-process.php' method='post' class="form-table" >
        <tr>
          <th scope="row"><label>Descrição</label></th>
          <td><input type="text" id="descricao"></td>
        </tr>
        <tr>
          <th scope="row"><label>Peso</label></th>
          <td><input type="number"> KG</td>
        </tr>
        <tr>
          <th scope="row"><label>Unidade</label></th>
          <td>
            <?php
              $unidade = new KidsPayUnidades();
              $unidade->getList();
              $unidade->Options_display();
            ?>
          </td>
        </tr>
        <tr>
          <th scope="row"><label>Grupo</label></th>
          <td>
            <?php
              $grupo = new KidsPayGrupos();
              $grupo->getList();
              $grupo->Options_display();
            ?>
          </td>
        </tr>
        <tr>
          <th><input type='submit' value='Concluir' class='button button-primary'></th>
        </tr>
      </table>
    <?php
  }

}
