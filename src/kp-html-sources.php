<?php
  $new_aluno_tab_name = _('Novo');
  function kp_aluno_menu_divtabs(){
    global $new_aluno_tab_name;
    ?>
    <script>
      window.onload = function(){document.getElementById("defaultOpen").click();}
    </script>
    <div class="tab">
      <?php
        $cliente = new KidsPayClientes();
        $alunos = $cliente->get_alunos();
        if(!count($alunos)){
          $cliente->Print("Não há alunos cadastrados");
        }
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

        ?>
        <button class="tablinks" id="defaultOpen" onclick="openDiv(event, '<?php echo $new_aluno_tab_name?>')">
          <?php echo "{$new_aluno_tab_name}";?>
        </button>
        <?php

        foreach ($alunos as $key => $value) {
          kp_aluno_tabs($value['id_aluno'], $value['nome'],'Atualizar');
        }
        kp_aluno_tabs(99,'Novo','Cadastrar');
      ?>
    </div>
    <?php
  }

  function kp_aluno_tabs($aluno='', $divname='', $action = ''){
    global $new_aluno_tab_name;
    ?>
      <div id='<?php echo "{$divname}" ?>' class="tabcontent">
        <form method='post' action='?page=kidspay-cad-alunos' ?>
          <table class="form-table" >
            <tr>
              <th scope="row"><label><?php if($divname!==$new_aluno_tab_name) echo "Aluno"; else echo "Aluno " . $new_aluno_tab_name;?></label></th>
              <td><input type="text" name="nome" value="<?php if($divname!==$new_aluno_tab_name) echo "{$divname}"; ?>"></td>
            </tr>
            <tr>
              <td>
                <input type='hidden' name='id' value='<?php echo "{$aluno}"; ?>'>

                <input type='submit' value='<?php echo $action ?>' name="action" class='button button-primary'>
                <?php
                  if($divname!=='Novo')
                  echo "<input type='submit' value='Deletar' name='action' class='button button-primary'>";
                ?>

              </td>
            </tr>
          </table>
        </form>
      </div>
    <?php
  }

  function kp_cred_menu_divtabs(){
    ?>
    <script>
      window.onload = function(){document.getElementById("defaultOpen").click();}
    </script>
    <div class="tab">
      <?php
        $cliente = new KidsPayClientes();
        $alunos = $cliente->get_alunos();
        if(!count($alunos)){
          $cliente->Print("Não há alunos cadastrados");
        }
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
          kp_cred_tabs($value['id_aluno'], $value['nome'] ,$value['credito'] - $value['gastos']);
        }
      ?>
    </div>
    <?php
  }

  function kp_cred_tabs($aluno, $divname, $valor_crd=0){
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
    $qnt = kp_cred_menu_divtabs();

  }

  function estornar_creditos_html(){
    $creditos = new KPCreditosList();
    $creditos->prepare_items();
    $creditos->display();
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
          <td><input type="checkbox" name="situacao" <?php if(isset($_REQUEST['situacao'])){ echo $_REQUEST['situacao']; }else{ echo 'A'; }?>></td>
        </tr>
        <tr>
          <th>
            <input type='submit' value='Concluir' class='button button-primary'>
          </th>
          <td><input type='hidden' name='action' value='<?php if(isset($acao)) echo "$acao"; else echo 'cad'; ?>'>
          <td><input type='hidden' name='id' value='<?php if(isset($_REQUEST['id_produto'])) echo $_REQUEST['id_produto']; ?>'>
        </tr>
      </table>
    <?php
  }

  function cadastrar_alunos_html(){

    $qnt = kp_aluno_menu_divtabs();

  }

?>
