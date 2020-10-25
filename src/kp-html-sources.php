<?php
  $new_aluno_tab_name = _('Cadastrar Novo');
  function kp_aluno_menu_divtabs(){
    global $new_aluno_tab_name;
    ?>
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
            <button class="tablinks" id="<?php echo "{$value['nome']}-button";?>" onclick="openDiv(event, '<?php echo "{$value['nome']}";?>')" >
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
        kp_aluno_tabs(99,$new_aluno_tab_name,'Cadastrar');
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
              <th scope="row"><label><?php if($divname!==$new_aluno_tab_name) echo "Aluno"; else echo $new_aluno_tab_name . " Aluno";?></label></th>
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
            <button class="tablinks" id='<?php echo "{$value['nome']}" . '-button';?>' onclick="openDiv(event, '<?php echo "{$value['nome']}";?>')" >
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
    add_thickbox();
    ?>
      <table class="form-table" enctype="multipart/form-data">
        <tr>
          <th scope="row"><label>Nome *</label></th>
          <td><input type="text" name="nome" value="<?php if(isset($_REQUEST['nome'])) echo $_REQUEST['nome']; ?>"></td>
        </tr>
        <tr>
          <th scope="row"><label>Descrição</label></th>
          <td><textarea  name="descricao"><?php if(isset($_REQUEST['descricao'])) echo $_REQUEST['descricao'];?></textarea></td>
        </tr>
        <tr>
          <th scope="row"><label>Preço Custo</label></th>
          <td><input type="number" step="0.01" name="preco_custo" value="<?php if(isset($_REQUEST['preco_custo'])) echo $_REQUEST['preco_custo']; ?>">R$</td>
        </tr>
        <tr>
          <th scope="row"><label>Preço Venda*</label></th>
          <td><input type="number" step="0.01" name="preco_venda" value="<?php if(isset($_REQUEST['preco_venda'])) echo $_REQUEST['preco_venda']; ?>">R$</td>
        </tr>
        <tr>
          <th scope="row"><label>Imagem</label></th>
          <td><Label type='button' for="image_path" class="button">Selecionar Imagem:</Label><Label><?php if(isset($_REQUEST['image_path'])){ echo basename($_REQUEST['image_path']); }?></label></td>
          <input type="file" id='image_path' name="image_path" style='visibility:hidden;' accept='image/png, image/jpeg'>
        </tr>
        <tr>
          <th scope="row"><label for="situacao">Ativo?</label></th>
          <td><input type="checkbox" name="situacao" <?php if(isset($_REQUEST['situacao'])){ echo $_REQUEST['situacao'];} ?>></td>
        </tr>
        <tr>
          <th>
            <input type='submit' value='Concluir' class='button button-primary'>
            <td>
              <a href='/wp-admin/admin.php?page=kidspay-rel-produtos'>
                <input type='button' value='Listar' class='button button-secondary'>
              </a>
              <?php if(isset($acao)){
                if($acao != 'cad'){
                  ?>
                  <a href='?page=kidspay-cad-produtos&action=del&id=<?php if(isset($_REQUEST['id_produto'])) echo $_REQUEST['id_produto'];?>'>
                    <input type='button' value='Deletar' class='button button-secondary'>
                  </a>
                  <?php
                }
              }
              ?>
            </td>
          </th>
        </tr>
        <tr>
          <input type='hidden' name='action' value='<?php if(isset($acao)) echo "$acao"; else echo 'cad'; ?>'>

          <input type='hidden' name='id' value='<?php if(isset($_REQUEST['id_produto'])) echo $_REQUEST['id_produto']; ?>'>
        </tr>
      </table>
    <?php
  }

  function cadastrar_alunos_html(){

    $qnt = kp_aluno_menu_divtabs();

  }


  function baixar_imagem($input_name){

    global $wpdb;
    $id = null;

    if(isset($_REQUEST['id'])){
      $id = $_REQUEST['id'];
    }

    if(!isset($input_name)){
      $form->PrintErro("Desculpe! não foi possível fazer o upload da imagem (erro interno)");
      return null;
    }

    $form = new KidsPayForms();
    if(isset($_FILES[$input_name])){
      if(!strlen($_FILES[$input_name]['name'])){
        if($id){
          $res = $wpdb->get_results("SELECT image_path FROM produtos WHERE id_produto = {$id};", ARRAY_A);
          if($res){
            $_REQUEST['image_path'] = $res[0]['image_path'];
          }
        }else{
          $form->PrintErro("Sem arquivo para imagem");
          $_REQUEST['image_path'] = null;
        }
        return $_REQUEST['image_path'];
      }
      $target_dir = KP_DIR . '/assets/imgs/' ;

      $target_file = $target_dir . basename($_FILES[$input_name]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $uploadOk = 1;

      if ($_FILES[$input_name]["size"] > 500000) {
        $form->PrintErro("Imagem do produto muito grande");
        $uploadOk = 0;
      }

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        echo "Use apenas arquivos JPG, JPEG, PNG & GIF. - {$imageFileType}";
        $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        $form->PrintErro("Não foi possível fazer o upload!");
        return null;
      } else {
        if (!move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
          $form->PrintErro("Desculpe! não foi possível fazer o upload da imagem");
          return null;
        }
      }

      $_REQUEST[$input_name] = KPPATH . '/assets/imgs/' . basename($_FILES[$input_name]["name"]);
      return $_REQUEST[$input_name];
    }else{
      $form->Print("Aviso! produto sem imagem");
    }

  }
?>
