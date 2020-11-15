<?php

class KPRestricoes{

  public function get_html_form(){
    ?>
    <table class='form-table'>

      <tr>
        <td>
          <Label>Produto</Label>
          <?php
            $produtos = new KidsPayProdutos();
            $produtosObjs = $produtos->get_produtos();
            $selected = '';
          ?>
          <select name='produto'>
            <option value='vazio'>Selecionar Produto</option>
            <?php foreach ($produtosObjs as $key => $value){
              if(isset($_REQUEST['produto'])){
                if($value['id_produto'] == $_REQUEST['produto'])
                  $selected = 'selected';
                else
                  $selected = '';
              }
              ?>
              <option <?php echo $selected; ?> value='<?php echo $value['id_produto'] ?>'>
                <?php echo $value['nome'] ?>
              </option>
            <?php } ?>
          </select>
          <Label>Aluno</Label>
          <?php
            $alunos = new KidsPayClientes();
            $alunosObjs = $alunos->get_alunos();
          ?>
          <select name='aluno'>
            <option value='vazio'>Selecionar Aluno</option>
            <?php
            $selected = '';
            foreach ($alunosObjs as $key => $value){
              if(isset($_REQUEST['aluno']))
                if($value['id_aluno'] == $_REQUEST['aluno'])
                  $selected = 'selected';
                else
                  $selected = '';
              ?>
            <option <?php echo $selected; ?>  value='<?php echo $value['id_aluno'] ?>'>
              <?php echo $value['nome'] ?>
            </option>
            <?php } ?>
          </select>
          <input type='submit' name='selecionar' value='Selecionar' class='button primary'>
        </td>
      </tr>
      <tr>
        <td>
          <textarea name='descricao' cols='50' rows='4'><?php if(isset($_REQUEST['descricao'])) echo $_REQUEST['descricao']; ?></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <Label>Ativo ?</Label>

          <input <?php if(isset($_REQUEST['ativo'])) if($_REQUEST['ativo']) echo 'checked'; ?> name='ativo' type='checkbox'>
        </td>
      </tr>

      <tr>
        <td>
          <?php
          if(isset($_REQUEST['existe'])){
            ?>
            <input type='submit' name='confirmar' value='<?php if($_REQUEST['existe'] == 1) echo 'Atualizar'; else echo 'Nova Restrição';?>' class='button primary'>
            <?php
          }else{
            ?>
            <input type='submit' name='confirmar' value='Atualizar' class='button primary'>
            <?php
          }
          ?>
        </td>
      </tr>

    </table>
    <?php
  }

  public function set_restricao($id_produto, $id_aluno){

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
