<?php

function mostrar_grafico_clientes(){
  global $wpdb;
  $dataPoints = array();
  $clientes = $wpdb->get_results("select sum(total), c.nome from vendas as v inner join clientes as c on v.id_cliente = c.id_cliente group by v.id_cliente;", ARRAY_A);
  if($clientes){
    foreach ($clientes as $key => $value) {
      $dataPoints[] = array("y" => $value['sum(total)'], "label" => $value['nome']);
    }
  }else{
    return ;
  }

  ?>
    <script type="text/javascript">
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
    	theme: "light1", // "light2", "dark1", "dark2"
    	animationEnabled: false, // change to true
    	title:{
    		text: "Clientes de maiores vendas"
    	},
      axisY: {
        title: "Crédito (em Reais)"
      },
    	data: [
    	{
    		// Change type to "bar", "area", "spline", "pie",etc.
        yValueFormatString: "R$ ####.00",
    		type: "column",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    	}
    	]
    });
    chart.render();

    }
    </script>
    </head>
    <body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
  <?php
}

function mostrar_grafico_produtos(){
  global $wpdb;
  $dataPoints = array();
  if(!current_user_can("manage_options"))
    $produtos = $wpdb->get_results("select sum(quantidade), p.nome from item_vendas as v inner join produtos as p on v.id_produto = p.id_produto inner join vendas as vnd on v.id_venda = vnd.id_venda where vnd.id_cliente = ". get_current_user_id()." group by v.id_produto;", ARRAY_A);
  else
    $produtos = $wpdb->get_results("select sum(quantidade), p.nome from item_vendas as v inner join produtos as p on v.id_produto = p.id_produto inner join vendas as vnd on v.id_venda = vnd.id_venda group by v.id_produto;", ARRAY_A);
  if($produtos){
    foreach ($produtos as $key => $value) {
      $dataPoints[] = array("y" => $value['sum(quantidade)'], "label" => $value['nome']);
    }
  }else{
    return ;
  }

  ?>

  <script>
  window.onload = function() {
  var chart = new CanvasJS.Chart("chartContainer", {
  	animationEnabled: true,
  	title: {
  		text: "<?php if(!current_user_can("manage_options")) echo "Produto mais comprados"; else echo "Produto mais vendidos"; ?>"
  	},
  	data: [{
  		type: "pie",
  		startAngle: 240,
  		yValueFormatString: "##0.00\"%\"",
  		indexLabel: "{label} {y}",
  		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  	}]
  });
  chart.render();
  }
  </script>
  <div id="chartContainer" style="height: 300px; width: 100%;"></div>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <?php
}

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
  global $meses;
  if($tipo_relat == 'Mensal'){
    foreach ($meses as $key => $value) {
      $valor = $wpdb->get_results("SELECT sum(total) FROM vendas WHERE month(dtvenda) = {$key} and year(dtvenda) = {$ano} {$query_args} and id_cliente = " . get_current_user_id(), ARRAY_A);
      if($valor){
        $dataPoints[] = array("y" => $valor[0]['sum(total)'], "label" => $value);
      }
    }
  }

  if($tipo_relat == 'Anual'){
    for($cont=2019;$cont<=date("Y");$cont++){
      $valor = $wpdb->get_results("SELECT sum(total) FROM vendas WHERE year(dtvenda) = {$cont} {$query_args} and id_cliente = " . get_current_user_id(), ARRAY_A);
      if($valor){
        $dataPoints[] = array("y" => $valor[0]['sum(total)'], "label" => $cont);
      }
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
