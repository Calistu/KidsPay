<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KPClientesList extends WP_List_Table{
  public function prepare_items(){

    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();

    $data = $this->table_data();
    usort( $data, array( &$this, 'sort_data' ) );
    $currentPage = $this->get_pagenum();
    $perPage = 5;
    $totalItems = sizeof($data)-1;

    $this->set_pagination_args( array(
        'total_items' => $totalItems,
        'per_page'    => $perPage
    ) );
    $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->items = $data;
  }

  public function get_columns(){
    return array(
      'id' => 'ID',
      'nome' => 'Nome',
      'cnpj_cpf' => 'CNPJ',
      'ie_rg' => 'IE/RG',
      'cep' => 'CEP'
    );
  }

  public function get_hidden_columns(){
    return array();
  }

  public function get_sortable_columns(){
    return array(
      'id' => array('id',true)
    );
  }

  private function table_data(){
    global $wpdb;
    $data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}clientes;", ARRAY_A);

    return $data;
  }

  public function column_default( $item, $column_name ){
    switch($column_name){
      case 'id':
      case 'nome':
      case 'cnpj_cpf':
      case 'ie_rg':
      case 'cep':
        return $item[ $column_name ];

      default:
          return print_r( $item, true ) ;
    }
  }

  private function sort_data( $a, $b ){
    $orderby = 'id';
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
