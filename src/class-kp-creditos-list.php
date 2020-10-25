<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KPCreditosList extends WP_List_Table{

  public function prepare_items(){

    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();
    $currentPage = $this->get_pagenum();

    $data = $this->table_data();
    $perPage = 10;
    $totalItems = count($data);

    $this->set_pagination_args( array(
      'total_items' => $totalItems,
      'per_page'    => $perPage
    ) );

    $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->items = $data;
    usort( $data, array( &$this, 'sort_data' ) );
  }

  public function get_columns(){

        return array(
          'id_credito_cliente' => 'ID',
          'aluno_nome' => 'Aluno',
          'dtpagamento' => 'Data',
          'valor' => 'Valor',
          'situacao' => 'Situação',
        );
      }

      public function get_hidden_columns(){
        return array('id_credito_cliente');
      }

      public function get_sortable_columns(){
        return array(
          'id_cliente' => array('id_cliente',true),
          'aluno_nome' => array('aluno_nome', true),
          'dtpagamento' => array('dtpagamento', true),
        );
      }

      private function table_data(){
        $cliente = new KidsPayClientes();
        $data = $cliente->getCredHist();
        return $data;
      }

      public function column_aluno_nome($item){
        $estorn_action = "<div class='row-actions'><span class='edit'><a href='?page=kidspay-crd-estorno&action=est&id={$item['id_credito_cliente']}'>Estornar</a></span></div>";
        $ativa_action =   "<div class='row-actions'><span class='edit'><a href='?page=kidspay-crd-estorno&action=ativ&id={$item['id_credito_cliente']}'>Reativar</a></span></div>";
        $recarrega_action = "<div class='row-actions'><span class='edit'><a href='?page=kidspay-crd-estorno&action=ativ&id={$item['id_credito_cliente']}'>Recarregar</a></span></div>";
        $situacao = '';

        switch ($item['situacao']) {
          case 'A':
            $situacao = 'Estornar';
            return "{$item['aluno_nome']}<br>{$estorn_action}</td>";

          case 'E':
            $situacao = 'Recarregar';
            return "{$item['aluno_nome']}<br>{$recarrega_action}</td>";

          case 'I':
            $situacao = 'Ativar';
            return "{$item['aluno_nome']}<br>{$ativa_action}</td>";

          default:
            $situacao = 'Situação não identificada';
            break;
        }
      }

      public function column_default( $item, $column_name ){
        switch($column_name){

          case 'valor':
            return "R$" . number_format(floatval($item['valor']),2);

          case 'dtpagamento':
            $tempo = strtotime($item[ 'dtpagamento' ]);
            return date("d/m/Y - H:i", $tempo);

          case 'situacao':
            if($item['situacao'] == 'A')
                $situacao = 'Ativo';
            if($item['situacao'] == 'I')
              $situacao = 'Inativo';
            if($item['situacao'] == 'E')
              $situacao = 'Estornado';
            return $situacao;

          case 'id_credito_cliente':
          case 'aluno_nome':

            return $item[ $column_name ];

          default:
              return print_r( $item, true ) ;
        }
      }

      private function sort_aluno_nome( $a, $b ){
        $orderby = 'aluno_nome';
        $order = 'asc';

        if(!empty($_GET['orderby'])){
          $orderby = $_GET['orderby'];
        }

        if(!empty($_GET['order'])){
          $order = $_GET['order'];
        }

        $result = strcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
      }
    }
