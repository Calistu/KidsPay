<?php

function kidspay_creditos_pdvdownload_page_display(){
  if(isset($_REQUEST['erro'])){
    $form = new KidsPayForms();
    $form->PrintErro("Não foi possível baixar");
  }
  ?>
  <link rel='stylesheets' href='{}';>
  <div class='wrap'>
    <h1 class='wp-heading-inline'>Download</h1>
    <hr class='wp-head-end'>
    <form action='<?php echo plugins_url( 'download-pdv.php' , __FILE__ ); ?>' method="post">
      <table class='form-table'>
        <tr>
          <td>
            <p class='box'>Baixe nosso PDV aqui, um sistema de ponto de venda com integração com nosso site.<br>
            Tenha os cadastros produtos, clientes, vendas todos unificados no seu ponto de venda</p>
          </td>
        </tr>
        <tr>
          <td><input class='button' type='submit' value='download'></td>
        </tr>
      </table>
    </form>
  </div>
  <?php

}
