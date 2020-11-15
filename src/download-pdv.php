<?php

define ('KPPATH','/wp-content/plugins/KidsPay');
define ('KP_DIR', __DIR__ );
define ('KP_VENDOR_DIR', __DIR__ . '/vendor/');

$target_file = '../assets/bin/PDV.rar' ;
$content = @file_get_contents($target_file);
if($content){
  header("Content-type: application/zip, application/octet-stream");
  header("Cache-Control: no-store, no-cache");
  header('Content-Disposition: attachment; filename="KidsPayPDV.zip"');
  echo $content;
}else{
  ?>
    <meta http-equiv="refresh" content="0; URL='/wp-admin/admin.php?page=kidspay-crd-pdv&erro'">
  <?php
}
