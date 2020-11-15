<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KPRestricoesList extends WP_List_Table{

  public function prepare_items(){

    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();

    $data = $this->table_data();
    usort( $data, array( &$this, 'sort_data' ) );
    $currentPage = $this->get_pagenum();
    $perPage = 15;
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
          'id_restricao' => 'ID',
          'descricao' => 'Descricao',
          'id_produto' => 'Produto',
          'id_aluno' => 'Aluno',
          'ativo' => 'Status',
        );
      }

      public function get_hidden_columns(){
        return array('id_restricao');
      }

      public function get_sortable_columns(){
        return array(
          'id_aluno' => array('id_aluno',true),
          'id_produto' => array('id_produto', true),
        );
      }

      private function table_data(){
        global $wpdb;
        $data = $wpdb->get_results("SELECT * FROM restricoes_produtos WHERE id_cliente = " . get_current_user_id(), ARRAY_A);
        return $data;
      }

      function column_id_aluno( $item ){
        global $wpdb;
        $aluno = $wpdb->get_results("SELECT nome FROM alunos WHERE id_aluno = {$item['id_aluno']}",ARRAY_A)[0]['nome'];
        return $aluno;
      }

      function column_id_produto( $item ){
        global $wpdb;
        $produto = $wpdb->get_results("SELECT nome FROM produtos WHERE id_produto = {$item['id_produto']}",ARRAY_A)[0]['nome'];
        return $produto;
      }

      function column_ativo( $item ){
        global $wpdb;
        if($item['ativo'] == 1)
          return 'Ativo';
        else
          return 'Inativo';
      }

      function column_descricao( $item ){
        global $wpdb;
        $actions = array(
          'delete' => sprintf("<a href='?page=kidspay-rel-restricoes&acao=deletar&id=%s'>%s</a> ", $item['id_restricao'], __('Delete')),
          'editar' => sprintf("<a href='?page=kidspay-cad-restricoes&selecionar&produto=%s&aluno=%s'>%s</a> ", $item['id_produto'], $item['id_aluno'], __('Editar')),
        );
        if($item['ativo'] == 1)
          $actions['desativar'] = sprintf("<a href='?page=kidspay-rel-restricoes&acao=desativar&id=%s'>%s</a>",  $item['id_restricao'], __('Desativar'));
        else
          $actions['ativer'] = sprintf("<a href='?page=kidspay-rel-restricoes&acao=ativar&id=%s'>%s</a>",  $item['id_restricao'], __('Ativar'));

        return sprintf('%s %s',
            $item['descricao'],
            $this->row_actions($actions));

      }


      private function sort_data( $a, $b ){
        $orderby = 'id_cliente';
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
