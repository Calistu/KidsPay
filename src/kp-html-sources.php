<?php

  function comprar_creditos_html(){
    ?>
    <table class="form-table" >
      <tr>
        <th scope="row"><label>Aluno</label></th>
        <td>
        <?php
          $cliente = new KidsPayClientes();
          $cliente->lista = $cliente->get_alunos();
          $cliente->Options_display('alunos');
        ?>
        </td>
      </tr>
      <tr>
        <th scope="row"><label>Saldo Atual</label></th>
        <td><input readonly type='number' value='<?php $cliente->getCredito(1)?>'>R$</td>
      </tr>
      <tr>
        <th scope="row"><label>Valor</label></th>
        <td><input type='number' name='valor'>R$</td>
      </tr>
      <tr>
        <th><input type='submit' value='Concluir' class='button button-primary'></th>
      </tr>
    </table>
    <input type='hidden' name='atualizando' value='true' class='button button-primary'>
    <?php
  }

  function cadastrar_cliente_html(){
    ?>



    <?php
  }


  function cadastrar_produtos_html($acao){
    ?>
      <table class="form-table" >
        <tr>
          <th scope="row"><label>Nome</label></th>
          <td><input type="text" name="nome"></td>
        </tr>
        <tr>
          <th scope="row"><label>Descrição</label></th>
          <td><input type="text" name="descricao"></td>
        </tr>
        <tr>
          <th scope="row"><label>Preço Custo</label></th>
          <td><input type="number" nome="preco_custo">R$</td>
        </tr>
        <tr>
          <th scope="row"><label>Preço Venda</label></th>
          <td><input type="number" name="preco_venda">R$</td>
        </tr>
        <tr>
          <th scope="row"><label for="situacao">Ativo?</label></th>
          <td><input type="checkbox" name="situacao" value='A' checked></td>
        </tr>
        <tr>
          <th><input type='submit' value='Concluir' class='button button-primary'></th>
          <td><input type='hidden' name='action' value='<?php if(isset($acao))echo "$acao"; else echo 'cad' ?>'>
        </tr>
      </table>
    <?php
  }



?>
