<?php

function KPPagSeguro_criar_sessao(){
  $form = new KidsPayForms();
  try {
      $sessionCode = \PagSeguro\Services\Session::create(
          \PagSeguro\Configuration\Configure::getAccountCredentials()
      );
      return $sessionCode->getResult();
  } catch (Exception $e) {
      $form->PrintErro('Criando Sessão: ' . $e->getMessage());
      return 0;
  }
}

function KPPagSeguro_receber_autorizacao(){
  $form = new KidsPayForms();
  try {
      \PagSeguro\Library::initialize();
  } catch (Exception $e) {
      $form->PrintErro($e);
      return 1;
  }
  \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
  \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

  $authorization = new \PagSeguro\Domains\Requests\Authorization();

  $authorization->setReference("AUTH_LIB_PHP_0001");
  $authorization->setRedirectUrl("http://www.lojamodelo.com.br");
  $authorization->setNotificationUrl("http://www.lojamodelo.com.br/nofitication");

  $authorization->addPermission(\PagSeguro\Enum\Authorization\Permissions::CREATE_CHECKOUTS);
  $authorization->addPermission(\PagSeguro\Enum\Authorization\Permissions::SEARCH_TRANSACTIONS);
  $authorization->addPermission(\PagSeguro\Enum\Authorization\Permissions::RECEIVE_TRANSACTION_NOTIFICATIONS);
  $authorization->addPermission(\PagSeguro\Enum\Authorization\Permissions::MANAGE_PAYMENT_PRE_APPROVALS);
  $authorization->addPermission(\PagSeguro\Enum\Authorization\Permissions::DIRECT_PAYMENT);

  try {
      $response = $authorization->register(
          \PagSeguro\Configuration\Configure::getApplicationCredentials()
      );
      $form->PrintOk( "<h2>Criando requisi&ccedil;&atilde;o de authorização</h2>"
          . "<p>URL do pagamento: <strong>" . $response . "</strong></p>"
          . "<p><a title=\"URL de Autorização\" href=\"" . $response  . "\" target=\_blank\">"
          . "Ir para URL de authorização.</a></p>" );
      $kp_hash = hash($response);
      $_REQUEST['kp_pag_autorizado'] = $kp_hash;
      return $kp_hash;
  } catch (Exception $e) {
    $form->PrintErro ($e->getMessage());
    return 0;
  }
}

function KPPagSeguro_receber_parcelas($options){

  $form = new KidsPayForms();
  if(!$options){
    $form->PrintErro("Erro ao receber parcelas");
    return 1;
  }

  \PagSeguro\Library::initialize();
  \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
  \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");


  try {
      $result = \PagSeguro\Services\Installment::create(
          \PagSeguro\Configuration\Configure::getAccountCredentials(),
          $options
      );
      $form->PrintErro($result->getInstallments());
  } catch (Exception $e) {
      $form->PrintErro ($e->getMessage());
      return 1;
  }
  return 0;
}
