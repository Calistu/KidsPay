<?php

require_once("../../../../../wp-load.php");

if(!isset($_REQUEST['kidspay_api'])){
  return 1;
}

$tabela = '';
$colunasArray = array();
$colunas = '';
$where = '';
$json = new \stdClass();
$json->status = 0;
$json->motivo = 'Nenhuma informação alterada';
header('Content-type: application/json; charset=utf-8');
$response = json_decode('');
if(isset($_REQUEST['tabela'])){
  $tabela = $_REQUEST['tabela'];
}

if(isset($_REQUEST['colunas'])){
  $colunasArray = $_REQUEST['colunas'];
}

if(isset($_REQUEST['where'])){
  $where = $_REQUEST['where'];
}

global $wpdb;
$res = $wpdb->get_results("SHOW COLUMNS FROM $tabela",ARRAY_A);
foreach ($colunasArray as $key => $coluna) {
  $exists = 0;
  foreach ($res as $key => $coluna_bd) {
    if($coluna == $coluna_bd['Field']){
      $exists = 1;
    }
  }

  reset($res);
  if(!$exists){
    $json->status = 300;
    $json->motivo = "Coluna {$coluna} não existe";
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    return 1;
  }
}

if($colunasArray)
  $colunas = implode(', ', $colunasArray);

$res = $wpdb->get_results("SELECT $colunas FROM $tabela where $where",ARRAY_A);
if($json){
  if($res){
    $json->status = 200;
    $json->motivo = 'consulta realizada';
    $json->resultado = json_encode($res);
  }else{
    $json->status = 404;
  //  $json->motivo = 'consulta vazia';
  //  $json->resultado = json_encode($res);
  }
}

echo json_encode($json, JSON_UNESCAPED_UNICODE);
