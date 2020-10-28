<?php

class KPRestricoes{

  public function restricoes_html_box($code = ''){
    global $wpdb;
    $produto = $wpdb->get_results("select p.nome, r.descricao, r.id_aluno, r.id_restricao from produtos as p left join restricoes_produtos as r on p.id_produto = r.id_produto where p.id_produto = " . $code ,ARRAY_A);
    ?>

    <div id='restrict-box<?php echo $code; ?>'  style="display:none;">
      <form action="" method="post">
        <table class="form-table" enctype="multipart/form-data">
          <tr>
              <td><Label style="font-weight: bold;">Produto: </label></td>
              <td><Label><?php if($produto and isset($produto[0])) echo $produto[0]['nome']; else echo "Erro ao buscar produto";?></label></td>
          </tr>
          <tr>
              <td><Label style="font-weight: bold;">Motivo da Restrição: </label></td>
              <td><textarea  name="descricao-restricao"><?php if(isset($produto[0]['descricao'])) echo $produto[0]['descricao']; ?></textarea></td>
          </tr>
          <tr>
            <td><Label style="font-weight: bold;">Aluno: </label></td>
            <td>
              <?php
                $alunos = $wpdb->get_results("select * from alunos where id_cliente = " . get_current_user_id() ,ARRAY_A);
              ?>
              <select size="5"  col='3' name='aluno-restricao' class='button-secondary'>
                <?php
                if($alunos){
                  $selected = '';
                  if(isset($produto[0]['id_aluno'])){
                    $selected = $produto[0]['id_aluno'];
                  }
                  foreach ($alunos as $key => $value){
                    if($selected == $value['id_aluno']){
                      $flag = 'selected';
                    }else{
                      $flag = '';
                    }
                    echo "<option $flag value='{$value['id_aluno']}'>{$value['nome']}</option>";
                  }
                }
                if(isset($produto[0]['id_restricao'])){
                  $altera = $produto[0]['id_restricao'];
                }else{
                  $altera = 0;
                }
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <input type='hidden' name='alterar-restricao' value='<?php echo $altera;?>'>
            <input type='hidden' name='produto-restricao' value='<?php echo $code;?>'>
            <td><input type='submit' name='restricao' value='Confirmar' class='button'></td>
          </tr>
        </table>
      </form>
    </div>

    <?php
  }


  public function requisicoes_processa_box(){
    global $wpdb;
    add_thickbox();
    $aluno = '';
    $descricao = '';
    $produto = '';

    if(isset($_REQUEST['restricao'])){

      $form = new KidsPayForms();

      if($_REQUEST['restricao'] == 'deletar'){
        if(!isset($_REQUEST['id'])){
          $form->PrintErro("Requisicao Invalida");
        }else{
          $id = $_REQUEST['id'];
          $res = $wpdb->delete('restricoes_produtos',
          array(
            'id_restricao' => $id
          ));
          if(!$res){
            $form->PrintErro("Nenhuma restrição deletada");
          }
        }
        return 0;
      }

      if(isset($_REQUEST['aluno-restricao'])){
        $aluno = $_REQUEST['aluno-restricao'];
      }else{
        $form->PrintErro("Escolha o aluno");
      }
      if(isset($_REQUEST['descricao-restricao'])){
        $descricao = $_REQUEST['descricao-restricao'];
      }
      if(isset($_REQUEST['produto-restricao'])){
        $produto = $_REQUEST['produto-restricao'];
      }else{
        $form->PrintErro("Insira o produto");
      }
      if(isset($_REQUEST['alterar-restricao'])){
        $alterar = $_REQUEST['alterar-restricao'];
      }


      if(!$alterar){
        $res = $wpdb->insert('restricoes_produtos',
        array(
          'id_produto' => $produto,
          'id_aluno' => $aluno,
          'descricao' => $descricao,
          'id_cliente' => get_current_user_id()
        ));
        if(!$res){
          if($wpdb->get_results("SHOW ERRORS")){
            $form->PrintErro("Erro ao inserir restricao");
          }
        }else{
          $form->PrintOk("Restrição criada");
        }
      }else{
        $res = $wpdb->update('restricoes_produtos',
        array(
          'descricao' => $descricao,
          'id_produto' => $produto,
          'id_aluno' => $aluno,
        ),array(
          'id_restricao' => $alterar,
          'id_cliente' => get_current_user_id()
        ));

        if(!$res){
          if($wpdb->get_results("SHOW ERRORS")){
            $form->PrintErro("Erro ao inserir restricao");
          }
        }else{
          $form->PrintOk("Restrição atualizada");
        }
      }
    }
  }

  public function get_restricoes($id = ''){
    global $wpdb;
    $where = '';
    if($id){
      $where = "where id_restricao = {$id}";
    }
    return $wpdb->get_results("SELECT * FROM restricoes_produtos {$where}",ARRAY_A);
  }
}
?>
