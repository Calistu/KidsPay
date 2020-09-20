<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KPClientesList extends WP_List_Table{
  public function prepare_items(){
    
  }

  public function get_columns(){

  }

  public function get_hidden_columns(){

  }

  public function get_sortable_columns(){

  }

  private function table_data(){

  }

  public function column_default( $item, $column_name ){

  }

  private function sort_data( $a, $b ){

  }
}
