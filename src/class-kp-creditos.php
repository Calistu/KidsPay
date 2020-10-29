<?php
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
            <td>R$ <input readonly type='number' id="credito-aluno" value='<?php echo number_format(floatval($valor_crd),2); ?>'></td>
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
?>
