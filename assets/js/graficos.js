window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light2",
  title:{
    text: "Vendas"
  },
  axisY: {
    title: "Crédito (em Reais)"
  },
  data: [{
    type: "column",
    yValueFormatString: "#,##0.## Reais",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});

chart.render();

}
