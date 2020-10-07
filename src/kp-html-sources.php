<?php

  function comprar_creditos_html(){

    $cliente = new KidsPayClientes();
    ?>
    <table class="form-table" >
      <tr>
        <th scope="row"><label>Aluno</label></th>
        <td>
        <?php

        $cliente->alunos = $cliente->get_alunos();
        $options = $cliente->alunos;
        echo "<select name='alunos' onchange='rec_cred_aluno(this)'>";
        if(!count($options)){
          echo "<option name='vazio' value='vazio'> Não há alunos cadastrados </option>";
        }
        foreach ($options as $list) {
          echo "<option name='aluno-{$list['nome']}' value='{$list['nome']}'> {$list['nome']} </option>";
        }
        echo "</select>";

        ?>
        </td>
      </tr>
      <tr>
        <?php
          global $wpdb
        ?>
        <th scope="row"><label>Saldo Atual</label></th>
        <td><input readonly type='number' id="credito-aluno" value='0.0'>R$</td>
      </tr>
      <tr>
        <th scope="row"><label>Valor</label></th>
        <td><input id="valor" type="number" name="valor">R$</td>
      </tr>
      <tr>
        <th><input type='submit' value='Concluir' class='button button-primary'></th>
      </tr>
    </table>
    <input type='hidden' name='atualizando' value='true'>
    <?php
  }

  function estornar_creditos_html(){
    ?>
      codigo

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

  function cadastrar_alunos_html(){
    ?>
      <table class="form-table" >
        <tr>
          <th scope="row"><label>Nome</label></th>
          <td><input type="text" name="nome"></td>
        </tr>
        <tr>
          <th><input type='submit' value='Concluir' class='button button-primary'></th>
          <td><input type='hidden' name='action' value='<?php if(isset($acao))echo "$acao"; else echo 'cad' ?>'>
        </tr>
      </table>
    <?php
  }

?>
