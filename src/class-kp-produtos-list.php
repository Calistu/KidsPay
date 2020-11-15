<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KPProdutosList extends WP_List_Table{

  function __construct(){
    //Set parent defaults
    parent::__construct( array(
      'singular'  => 'produto',     //singular name of the listed records
      'plural'    => 'produtos',    //plural name of the listed records
      'ajax'      => false        //does this table support ajax?
    ) );
  }

  public function prepare_items(){

    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();

    $data = $this->table_data();
    usort( $data, array( &$this, 'sort_data' ) );

    $currentPage = $this->get_pagenum();
    $perPage = 10;
    $totalItems = count($data);

    $this->set_pagination_args( array(
        'total_items' => $totalItems,
        'per_page'    => $perPage
    ) );

    $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->items = $data;

    $this->process_bulk_action();
  }

  public function get_columns(){
    return array(
      'cb' => '<input type="checkbox" />',
      'id_produto' => 'Id',
      'nome' => __('Name'),
      'descricao' => __('Description'),
      'preco_custo' => 'Preço de Custo',
      'preco_venda' => 'Preço de Venda',
      'image_path' => __('Image'),
      'situacao' => 'Situação'
    );
  }

  public function column_image_path($item){
    if($item['image_path']){
      $imagem = "<img style='width:20px;' src='{$item['image_path']}'>";
      return "<div>{$imagem}</div>";
    }
    else{
      return "Sem imagem";
    }
  }

  public function column_nome($item){
    if(current_user_can("manage_options")){
      $actions = array(
        'edit' => sprintf("<a href='?page=kidspay-cad-produtos&action=alt&id=%s'>%s</a> ", $item['id_produto'], __( 'Change' )),
        'delete' => sprintf("<a href='?page=kidspay-rel-produtos&action=del&id=%s'>%s</a> ", $item['id_produto'], __('Delete')),
        'restricao' => sprintf("<a href='?page=kidspay-cad-restricoes&produto=%s'>%s</a> ", $item['id_produto'], __('Restrição')),
      );
    }else{
      $actions = array();
    }

    return sprintf('%s %s',
        $item['nome'],
        $this->row_actions($actions));
  }

  public function get_hidden_columns(){
    return array(
      'id_produto'
    );
  }

  public function get_sortable_columns(){
    return array(
      'preco_custo' => array('preco_custo', true),
      'preco_venda' => array('preco_venda', true)
    );
  }

  private function table_data(){
    global $wpdb;
    $data = array();
    $data =  $wpdb->get_results("select * from produtos", ARRAY_A);//);

    return $data;
  }

  function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="ID[]" value="%s" />', $item['id_produto']
        );
    }


  public function column_default( $item, $column_name ){
    switch( $column_name ) {

      case 'situacao':
        if($item[ $column_name ] === 'A')
          return 'Ativo';
        else
        if($item[ $column_name ] === 'I')
          return 'Inativo';

      case 'preco_custo':
        return "R$ " . number_format(floatval($item[ $column_name ]),2);

      case 'preco_venda':
        return "R$ " . number_format(floatval($item[ $column_name ]),2);

      case 'id_produto':
      case 'nome':
      case 'descricao':
        return $item[ $column_name ];

      default:
          return print_r( $item, true ) ;
    }
  }

  function extra_tablenav( $which ) {
    ?>

    <?php
  }

  function get_bulk_actions(){
    $actions = array();

    if(current_user_can("manage_options")){
      $actions['delete'] = __( 'Delete' );
    }
    return $actions;
  }

  function process_bulk_action() {
    global $wpdb;
    //Detect when a bulk action is being triggered...
    if( 'delete' === $this->current_action() ) {
      $form = new KidsPayForms();
      foreach ($_GET as $key => $value) {
        // code...
        if($key === 'ID'){
          foreach ($value as $key2 => $value2) {
            if(!$wpdb->delete('produtos', array('id_produto' => $value2))){
              $form->Print("Produto {$value2} não deletado");
            }
          }
        }
      }
    }
  }


  function sort_data( $a, $b ){
    // Set defaults/
    $orderby = 'id_produto';
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
