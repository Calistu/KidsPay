<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KPComprasList extends WP_List_Table{
  public function prepare_items(){

    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();

    $data = $this->table_data();
    usort( $data, array( &$this, 'sort_data' ) );

    $currentPage = $this->get_pagenum();
    $perPage = 2;
    $totalItems = count($data);

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
      'pedido' => 'ID',
      'produto' => 'Descrição Produto',
      'unidades' => 'Unidades',
      'valor_unit' => 'Valor Unitário',
      'desconto' => 'Desconto',
      'total' => 'Total',
      'observacao' => 'Observação'
    );
  }

  public function get_hidden_columns(){
    return array();
  }

  public function get_sortable_columns(){
    return array(
      'pedido' => array('pedido', true)
    );
  }

  private function table_data(){
    $usuario = new WP_User();
    global $wpdb;
    global $kpdb;
    $dataatual = date('Y-m-d H:i:s');
    $data = $wpdb->get_results(";", ARRAY_A);

    return $data;
  }


  public function column_default( $item, $column_name ){
    switch( $column_name ) {
        case 'pedido':
        case 'produto':
        case 'unidades':
        case 'valor_unit':
        case 'desconto':
        case 'total':
        case 'observacao':
            return $item[ $column_name ];

        default:
            return print_r( $item, true ) ;
    }
  }

  private function sort_data( $a, $b ){
    // Set defaults
    $orderby = 'pedido';
    $order = 'asc';

    // If orderby is set, use this as the sort column
    if(!empty($_GET['orderby']))
    {
        $orderby = $_GET['orderby'];
    }

    // If order is set use this as the order
    if(!empty($_GET['order']))
    {
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
