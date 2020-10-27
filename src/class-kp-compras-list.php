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
    $perPage = 20;
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
      'id_venda' => 'ID',
      'id_aluno' => 'Aluno',
      'dtvenda' => 'Data',
      'total' => 'Total',
      'situacao' => 'Situacao',
      'total' => 'Total',
    );
  }

  public function get_hidden_columns(){
    return array('id_venda');
  }

  public function get_sortable_columns(){
    return array(
      'dtvenda' => array('dtvenda', true),
      'id_aluno' => array('id_aluno', true),
      'total' => array('total', true),
    );
  }

  private function table_data(){
    $usuario = new WP_User();
    global $wpdb;
    $cliente = new KidsPayClientes();
    $dataatual = date('Y-m-d H:i:s');
    $data = $wpdb->get_results("SELECT * FROM vendas WHERE id_cliente = {$cliente->get_loginid()}" , ARRAY_A);
    return $data;
  }


  public function column_default( $item, $column_name ){
    switch( $column_name ) {
        case 'id_aluno':
          global $wpdb;
          $res = $wpdb->get_results("SELECT nome FROM alunos WHERE id_aluno = {$item[ $column_name ]}", ARRAY_A);
          return $res[0][ 'nome' ];
        case 'dtvenda':
          $tempo = strtotime($item[ $column_name ]);
          return date("d/m/Y - H:i", $tempo);
        case 'total':
          return "R$ " . number_format(floatval($item[ $column_name ]),2);

        case 'situacao':
          switch ($item[ $column_name ]) {
            case 'A':
              return "Ativo";
              break;
            case 'D':
              return "Devolvido";
              break;
            case 'C':
              return "Cancelado";

            default:
              return "Sem status";
              break;
          }

        case 'id_venda':
        case 'total':
          return $item[ $column_name ];

        default:
            return print_r( $item, true ) ;
    }
  }

  private function sort_data( $a, $b ){
    // Set defaults
    $orderby = 'dtvenda';
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
