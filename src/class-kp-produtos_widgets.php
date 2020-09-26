<?php

class ProdutosWidgets extends WP_Widget {

  function __construct(){
    parent::__construct(
      'KidsPay',
      'Lista Produtos',
    );

  }

	public function widget( $args, $instance ) {

	}

	public function form( $instance ) {
    ?>
    <h6>Listar Produtos por:</h6>
    <select class='cd-select'>
      <option value='ultimos'>Últimos Adicionados</option>
      <option value='mais_vendas'>Mais Vendidos</option>
      <option value='cardapio'>Do Cadápio</option>
    </select>
    <?php
	}

	public function update( $new_instance, $old_instance ) {

	}
}

add_action('widgets_init',function(){
  register_widget('ProdutosWidgets');
});
