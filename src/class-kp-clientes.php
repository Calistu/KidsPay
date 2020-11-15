<?php

class KidsPayClientes extends KidsPayForms{

  function __construct(){
    $this->table = 'clientes';
    $this->new_aluno_tab_name= _('Cadastrar Novo');
  }
  public $alunos;

  public function get_loginid(){
    global $wpdb;
    $res = $wpdb->get_results('SELECT id_cliente FROM clientes WHERE id_cliente = ' . get_current_user_id(),ARRAY_A);
    if($res)
      return $res[0]['id_cliente'];
    else
      return null;
  }

  public function insert_loginid(){
    global $wpdb;
    $login_atual = get_userdata(get_current_user_id());
    $login_user = array(
      'id_cliente' => $login_atual->ID,
      'nome' => $login_atual->user_login
    );
    return $wpdb->insert('clientes',$login_user);
  }

  public function get_alunoid_pnome($var){
    global $wpdb;
    $res = $wpdb->get_results('SELECT a.id_aluno FROM alunos as a INNER JOIN clientes as c on a.id_cliente = c.id_cliente WHERE c.id_cliente = ' . get_current_user_id() . " and a.nome = '$var'", ARRAY_A);

    if($res and $res[0]['id_aluno']){
      return $res[0]['id_aluno'];
    }
    else{
      $form = new KidsPayForms();
      $form->PrintErro('Não foi possível encontrar id do aluno');
      $form->PrintErro($wpdb->print_error());
    }
  }


  public function getCredHist($id = null){
    global $wpdb;

    $args = '';
    if($id){
      $args = ' and id_credito_cliente = '.$id;
    }

    $res = $wpdb->get_results('SELECT * FROM credito_clientes WHERE id_cliente = ' . get_current_user_id() . $args, ARRAY_A);

    if($res){
      foreach ($res as $key => $value){
        $alunos = $this->get_alunos($value['id_aluno']);
        $res[$key]['aluno_nome'] = $alunos[0]['nome'];
      }
    }

    return $res;
  }

  public function get_alunos($aluno = null){
    global $wpdb;
    $form = new KidsPayForms();
    if($aluno){
      $aluno_args = ' and id_aluno = ' . $aluno;
    }else{
      $aluno_args = '';
    }
    $res = $wpdb->get_results('SELECT id_aluno, nome FROM alunos WHERE id_cliente = ' . get_current_user_id() . $aluno_args, ARRAY_A);

    //receber creditos de cada aluno
    foreach ($res as $key => $value) {

     $credito = $wpdb->get_results(
      'SELECT SUM(valor) FROM credito_clientes'
      . ' WHERE id_cliente = '
      . get_current_user_id()
      . ' and situacao = '
      . "'A'"
      . ' and id_aluno = '
      . $value['id_aluno'],
      ARRAY_A);

      if($credito){
        $res[$key]['credito'] = $credito[0]['SUM(valor)'];
      }else{
        $res[$key]['credito'] = 0;
      }

      //receber gastos de cada aluno
      $gastos = $wpdb->get_results(
      'SELECT SUM(total) FROM vendas'
      . ' WHERE id_cliente = '
      . get_current_user_id()
      . ' and id_aluno = '
      . $value['id_aluno'],
      ARRAY_A);
      if($gastos){
          $res[$key]['gastos'] = $gastos[0]['SUM(total)'];
      }else{
        $res[$key]['gastos'] = 0;
      }

      $res[$key]['saldo'] = $res[$key]['credito'] - $res[$key]['gastos'];

    }

    return $res;
  }

  public $new_aluno_tab_name;
  public function kp_aluno_menu_divtabs(){

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
        <button class="tablinks" onclick="openDiv(event, '<?php echo $this->new_aluno_tab_name?>')">
          <?php echo "{$this->new_aluno_tab_name}";?>
        </button>
        <?php

        foreach ($alunos as $key => $value) {
          $this->kp_aluno_tabs($value['id_aluno'], $value['nome'],'Atualizar');
        }
        $this->kp_aluno_tabs(99,$this->new_aluno_tab_name,'Cadastrar');
      ?>
    </div>
    <?php
  }

  public function kp_aluno_tabs($aluno='', $divname='', $action = ''){

    ?>
      <div id='<?php echo "{$divname}" ?>' class="tabcontent">
        <form method='post' action='?page=kidspay-cad-alunos' ?>
          <table class="form-table" >
            <tr>
              <th scope="row"><label><?php if($divname!==$this->new_aluno_tab_name) echo "Aluno"; else echo $this->new_aluno_tab_name . " Aluno";?></label></th>
              <td><input type="text" id='nome_alunos' name="nome" value="<?php if($divname!==$this->new_aluno_tab_name) echo "{$divname}"; ?>"></td>
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

  public function cadastrar_alunos_html(){

    $qnt = $this->kp_aluno_menu_divtabs();

  }

  public function display_cad_form(){
  ?>
    <form method='post' action='#' ?>
      <table class="form-table" >
        <tr>
          <th scope="row"><label>Data Nascimento</label></th>
          <td><input class='text' type='text'></input></td>
        </tr>
        <tr>
          <th scope="row"><label>RG</label></th>
          <td><input class='text' type='text'></input></td>
        </tr>
        <tr>
          <th scope="row"><label>CPF</label></th>
          <td><input class='text' type='text'></input></td>
        </tr>
      </table>
    </form>
  <?php
  }

}
