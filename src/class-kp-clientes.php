<?php

class KidsPayClientes extends KidsPayForms{

  function __construct(){
    $this->table = 'clientes';
  }
  public $alunos;

  public function get_loginid(){
    global $wpdb;
    $res = $wpdb->get_results('SELECT id_cliente FROM clientes WHERE id_cliente = ' . get_current_user_id(),ARRAY_A);
    return $res[0]['id_cliente'];
  }

  public function insert_loginid(){
    global $wpdb;
    $login_atual = get_userdata(get_current_user_id());
    $login_user = array(
      'id_cliente' => $login_atual->id,
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
}
