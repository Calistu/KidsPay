<?php
if(isset($_GET['arquivo'])){
  @$file = fopen($_GET['arquivo'],'r');
  if($file){
    header("Content-type: image/jpeg");
    header("Cache-Control: no-store, no-cache");
    header("Content-Disposition: attachment; filename={$_GET['arquivo']}");
    header('Pragma: no-cache');
    readfile( $_GET['arquivo'] );
  }else{
    echo "Arquivo não existente";
  }
}else{
  echo "Requisição inválida";
}
