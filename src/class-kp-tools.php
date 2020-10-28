<?php

function baixar_imagem($input_name){

  global $wpdb;
  $id = null;

  if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
  }

  if(!isset($input_name)){
    $form->PrintErro("Desculpe! não foi possível fazer o upload da imagem (erro interno)");
    return null;
  }

  $form = new KidsPayForms();
  if(isset($_FILES[$input_name])){
    if(!strlen($_FILES[$input_name]['name'])){
      if($id){
        $res = $wpdb->get_results("SELECT image_path FROM produtos WHERE id_produto = {$id};", ARRAY_A);
        if($res){
          $_REQUEST['image_path'] = $res[0]['image_path'];
        }
      }else{
        $form->PrintErro("Sem arquivo para imagem");
        $_REQUEST['image_path'] = null;
      }
      return $_REQUEST['image_path'];
    }
    $target_dir = KP_DIR . '/assets/imgs/' ;

    $target_file = $target_dir . basename($_FILES[$input_name]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $uploadOk = 1;

    if ($_FILES[$input_name]["size"] > 500000) {
      $form->PrintErro("Imagem do produto muito grande");
      $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Use apenas arquivos JPG, JPEG, PNG & GIF. - {$imageFileType}";
      $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $form->PrintErro("Não foi possível fazer o upload!");
      return null;
    } else {
      if (!move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
        $form->PrintErro("Desculpe! não foi possível fazer o upload da imagem");
        return null;
      }
    }

    $_REQUEST[$input_name] = KPPATH . '/assets/imgs/' . basename($_FILES[$input_name]["name"]);
    return $_REQUEST[$input_name];
  }else{
    $form->Print("Aviso! produto sem imagem");
  }

}
