<?php

class KidsPayProdutos extends KidsPayForms{

  public $id = 0;
  public $nome = '';
  public $peso = 0.0;
  public $unidade = 0;
  public $grupo = 0;
  public $observacoes = '';

  public function prod_semana_html_form(){
    global $dias, $wpdb;
    $dias2 = array(
      1 => 'segunda',
      2 => 'terca',
      3 => 'quarta',
      4 => 'quinta',
      5 => 'sexta'
    );
    $form = new KidsPayForms();
    if(isset($_REQUEST['reseta'])){
      $res = $wpdb->query('DELETE FROM promocao_diaria');
      if(!$res){
        $form->Print("Nada Atualizado");
      }
    }else
    if(isset($_REQUEST['atualiza'])){
      foreach ($dias as $key => $value) {
        if(isset($_REQUEST['produto-' . $dias[$key]])){
          if($_REQUEST['produto-' . $dias[$key]] == 'nenhum'){
            $wpdb->delete('promocao_diaria',array(
              'semana' => $dias2[$key],
            ));
            continue;
          }

          $promocoes = $wpdb->get_results("SELECT * FROM promocao_diaria WHERE semana = '{$dias2[$key]}' ");
          if(!$promocoes){
            $res = $wpdb->insert('promocao_diaria',array(
            'semana' => $dias2[$key],
            'nome' => $_REQUEST['nome-' . $dias[$key]],
            'valor' => $_REQUEST['valor-' . $dias[$key]],
            'id_produto' => $_REQUEST['produto-' . $dias[$key]]
          ));
          if(!$res){
            $form->PrintErro("Não foi possível criar promoção");
          }
          }else{
            $res = $wpdb->update('promocao_diaria',array(
              'nome' => $_REQUEST['nome-' . $dias[$key]],
              'valor' => $_REQUEST['valor-' . $dias[$key]],
              'id_produto' => $_REQUEST['produto-' . $dias[$key]]
            ),array(
              'semana' => $dias2[$key])
            );
            if(!$res){
              $erro = $wpdb->get_results("SHOW ERRORS");
              if($erro){
                $form->PrintErro("Não foi possível atualizar promoção");
                break;
              }
            }
          }
        }
      }
      $form->PrintOk("Processo Finalizado");
    }else{
      $cont = 1;
      $promocoes = $wpdb->get_results("SELECT * FROM promocao_diaria",ARRAY_A);
      foreach ($promocoes as $key => $value) {
        $_REQUEST['nome-'.$dias[$cont]] = $value['nome'];
        $_REQUEST['valor-'.$dias[$cont]] = $value['valor'];
        $_REQUEST['produto-'.$dias[$cont]] = $value['id_produto'];
        $_REQUEST['semana-'.$dias[$cont]] = $value['semana'];
        $cont++;
      }
    }

    ?>
    <table class='table-form'>
      <form action='?page=kidspay-cad-prodsem' method="post">
        <tr>
        <?php
        foreach ($dias as $key => $value) {
          ?>
          <td valign="top" class='manage-column column-cb' scope='col'>
            <div  class='promocao-container'>
              <Label style="font-weight:bold;" for='produto_select<?php echo $value;?>' class='Label'><?php echo ucfirst(__($value)); ?></Label>

              <div class='promocao-inputs'>
                <Label style="font-weight:bold;">Nome:</Label>
                <input type='text' name='nome-<?php echo $value;?>' class='text' value='<?php if(isset($_REQUEST['nome-'.$value])) echo $_REQUEST['nome-'.$value]; ?>'>
              </div>

              <div class='promocao-inputs'>
                <Label style="font-weight:bold;">Valor:</Label>
                <input class="text" type="text" type='number' name='valor-<?php echo $value;?>' class='text' value='<?php if(isset($_REQUEST['valor-'.$value])) echo number_format(floatval($_REQUEST['valor-'.$value]),2); ?>'>
              </div>

              <select size="5" id='produto_select<?php echo $value;?>' name='produto-<?php echo $value;?>' class='button-secondary'>
                <?php
                $produtos = $wpdb->get_results("select * from produtos where situacao = 'A'",ARRAY_A);
                if($produtos){
                  $selected = '';
                  if(isset($_REQUEST['produto-' . $value])){
                    $selected = $_REQUEST['produto-' . $value];
                  }
                  echo "<option value='nenhum'>Nenhum</option>";

                  foreach ($produtos as $key => $value2){
                    if($selected == $value2['id_produto']){
                      $flag = 'selected';
                    }else{
                      $flag = '';
                    }
                    echo "<option $flag value='{$value2['id_produto']}'>{$value2['nome']}</option>";
                  }
                }
                ?>
              </select>
            </div>
          </td>
          <?php
        }
        ?>
        </tr>
        <tr valign="top" scope="row" class='manage-column column-cb' >
          <td><input type='submit' name='atualiza' value='Atualizar' class='button-primary'></td>
          <td><input type='submit' name='reseta' value='Resetar' class='button'></td>
        </tr>
      </form>
    </table>
    <?php
  }

  function get_restricoes($aluno = null){
    global $wpdb;
    $aluno_where = '';
    if($aluno){
      $aluno_where = " id_aluno = ${aluno}";
    }
    $resticoes = $wpdb->get_results("SELECT * FROM restricoes_produtos {$aluno_where}", ARRAY_A);
    return $resticoes;
  }


  function get_produtos($id=0){
    global $wpdb;
    $where = '';
    if($id)
      $where = "WHERE id_produto = {$id}";
    $res = $wpdb->get_results("SELECT * FROM produtos ${where}", ARRAY_A);
    return $res;
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


}
