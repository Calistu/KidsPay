<?php

  function kp_menu_tabs(){
    ?>
    <script>
      window.onload = function(){document.getElementById("defaultOpen").click();}
    </script>
    <div class="tab">
      <?php
        $cliente = new KidsPayClientes();
        $alunos = $cliente->get_alunos();
        $cont=0;
        foreach ($alunos as $key => $value) {
          if(!$cont){
            ?>
            <button class="tablinks" id="defaultOpen" onclick="openDiv(event, '<?php echo "{$value['nome']}"?>')">
              <?php echo "{$value['nome']}";?>
            </button>
            <?php
          }else{
            ?>
            <button class="tablinks" onclick="openDiv(event, '<?php echo "{$value['nome']}";?>')" >
              <?php echo "{$value['nome']}";?>
            </button>
            <?php
          }
          $cont++;
        }
        foreach ($alunos as $key => $value) {
          kp_credito_tabs($value['id_aluno'], $value['nome'] ,$value['credito'] - $value['gastos']);
        }
      ?>
    </div>
    <?php
  }

  function kp_credito_tabs($aluno, $divname, $valor_crd=0){
    ?>
      <div id='<?php echo "$divname" ?>' class="tabcontent">
        <form method='post' action='?page=kidspay-crd-comprar'>
          <table class="form-table" >
            <tr>
              <th scope="row"><label>Saldo Atual</label></th>
              <td>R$ <input readonly type='number' id="credito-aluno" value='<?php echo "{$valor_crd}"; ?>'></td>
            </tr>
            <tr>
              <th scope="row"><label>Valor</label></th>
              <td>R$ <input id="valor" type="number" name="valor"></td>
            </tr>
            <tr>
              <td><input type='submit' value='Concluir' class='button button-primary'></td>
              <input type='hidden' name='atualizando' value='true'>
              <input type='hidden' name='aluno' value='<?php echo "{$aluno}"; ?>'>
            </tr>
          </table>
        </form>
      </div>
    <?php
  }

  function comprar_creditos_html(){

    $cliente = new KidsPayClientes();
    $qnt = kp_menu_tabs();

  }

  function estornar_creditos_html(){
    ?>


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
          <td><input type="text" name="nome" value="<?php if(isset($_REQUEST['nome'])) echo $_REQUEST['nome']; ?>"></td>
        </tr>
        <tr>
          <th scope="row"><label>Descrição</label></th>
          <td><input type="text" name="descricao" value="<?php if(isset($_REQUEST['descricao'])) echo $_REQUEST['descricao']; ?>"></td>
        </tr>
        <tr>
          <th scope="row"><label>Preço Custo</label></th>
          <td><input type="number" step="0.05" name="preco_custo" value="<?php if(isset($_REQUEST['preco_custo'])) echo $_REQUEST['preco_custo']; ?>">R$</td>
        </tr>
        <tr>
          <th scope="row"><label>Preço Venda</label></th>
          <td><input type="number" step="0.5" name="preco_venda" value="<?php if(isset($_REQUEST['preco_venda'])) echo $_REQUEST['preco_venda']; ?>">R$</td>
        </tr>
        <tr>
          <th scope="row"><label for="situacao">Ativo?</label></th>
          <td><input type="checkbox" name="situacao" value='A' checked></td>
        </tr>
        <tr>
          <th>
            <input type='submit' value='Concluir' class='button button-primary'>
          </th>
          <td><input type='hidden' name='action' value='<?php if(isset($acao))echo "$acao"; else echo 'cad' ?>'>
          <td><input type='hidden' name='id' value='<?php echo $_REQUEST['id_produto'] ?>'>
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
