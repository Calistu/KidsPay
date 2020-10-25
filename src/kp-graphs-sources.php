<?php
function mostrar_grafico_vendas(){

  if(isset($_REQUEST['ano_relatorio'])){
    $ano = $_REQUEST['ano_relatorio'];
  }else{
    $ano = date("Y");
  }

  if(isset($_REQUEST['tipo_relatorio'])){
    $tipo_relat = $_REQUEST['tipo_relatorio'];
  }else{
    $tipo_relat = 'Mensal';
  }

  if(isset($_REQUEST['aluno'])){
    $aluno = $_REQUEST['aluno'];
  }else{
    $aluno = 'todos';
  }

  global $wpdb;

  $query_args = '';
  $aluno_args = '';
  if($aluno !== 'todos'){
    $aluno_args = "and id_aluno = {$aluno}";
  }

  $query_args .= $aluno_args;

  if($tipo_relat == 'Mensal'){
    $meses = array(
      1 => __("January"),
      2 => __("February"),
      3 => __("March"),
      4 => __("April"),
      5 => __("May"),
      6 => __("June"),
      7 => __("July"),
      8 => __("August"),
      9 => __("September"),
      10 => __("October"),
      11 => __("November"),
      12 => __("December"),
    );

    foreach ($meses as $key => $value) {
      $valor = $wpdb->get_results("SELECT sum(total) FROM vendas WHERE month(dtvenda) = {$key} and year(dtvenda) = {$ano} {$query_args} and id_cliente = " . get_current_user_id(), ARRAY_A);
      if($valor)
        $dataPoints[] = array("y" => $valor[0]['sum(total)'], "label" => $value);
    }
  }

  if($tipo_relat == 'Anual'){
    for($cont=2019;$cont<=date("Y");$cont++){
      $valor = $wpdb->get_results("SELECT sum(total) FROM vendas WHERE year(dtvenda) = {$cont} {$query_args} and id_cliente = " . get_current_user_id(), ARRAY_A);
      if($valor)
        $dataPoints[] = array("y" => $valor[0]['sum(total)'], "label" => $cont);
    }

  }

  ?>
  <script>
  window.onload = function() {

  var chart = new CanvasJS.Chart("chartContainer", {
  	animationEnabled: true,
  	theme: "light2",
  	title:{
  		text: "Relatório <?php echo "{$tipo_relat} {$ano}";?>"
  	},
  	axisY: {
  		title: "Crédito (em Reais)"
  	},
  	data: [{
  		type: "column",
  		yValueFormatString: "R$ ####.00 Reais",
  		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  	}]
  });

  chart.render();

  }
  </script>
  <div>
    <form method="post" action='?page=kidspay-rel-tools'>
      <table class='form-table'>
        <td>
          <select name='ano_relatorio'>
            <?php
            $select = '';
            for($cont=2019;$cont<=date("Y");$cont++){
              if($cont == $ano){
                $select = 'selected';
              }
              echo "<option {$select} value='{$cont}'>Ano {$cont}</>";
            }
            ?>
          </select>
          <input type="submit" value='Selecionar Ano' class='button'>
        </td>
        <td>
          <select name='tipo_relatorio'>
            <?php
            if($tipo_relat == 'Mensal'){
              $sel = 'selected';
            }else {
              $sel = '';
            }?>
            <option <?php echo $sel; ?> value='Mensal'>Mensal</option>
            <?php
            if($tipo_relat == 'Anual'){
              $sel = 'selected';
            }else{
              $sel = '';
            }?>
            <option <?php echo $sel; ?> value='Anual'>Anual</option>
          </select>
          <input type="submit" value='Selecionar Tipo' class='button'>
        </td>
        <td>
          <select name='aluno'>
            <option value='todos'>Todos</option>
            <?php
              $res = $wpdb->get_results('SELECT id_aluno, nome FROM alunos WHERE id_cliente = ' . get_current_user_id(), ARRAY_A);
              if($res){
                $select = '';
                foreach ($res as $key => $value) {
                  if($aluno == $value['id_aluno']){
                    $select = 'selected';
                  }else{
                    $select = '';
                  }
                  echo "<option value='{$value['id_aluno']}' $select>{$value['nome']}</option>";
                }
              }
            ?>
          </select>
          <input type="submit" value='Selecionar Aluno' class='button'>
        </td>
        </tr>
      </table>
      <div id="chartContainer"></div>
    </form>
  </div>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <?php
}
