<?php

class ProdutosWidgets extends WP_Widget {

  function __construct(){
    parent::__construct(
      'KidsPay',
      'Listar Produtos KidsPay',
    );

  }

	public function widget( $args, $instance ) {
    global $wpdb;

    if(isset($instance['tipo_lista']))
      $tipo = apply_filters('widget_title', $instance['tipo_lista']);

    if(isset($instance['qnt_itens']))
      $qnt_itens = $instance['qnt_itens'];

    echo $args['before_widget'];

    $label = '';
    $query = '';
    if ( ! empty( $tipo ) ){
      switch ($instance['tipo_lista']) {

        case 'mais_vendas':
          $label = "Mais Vendidos:";
          $query = 'select p.* from produtos as p inner join item_vendas as v on v.id_produto = p.id_produto';
          break;
        case 'promocao':
          $label = "Promoção do dia:";
          $query = "select p.*,s.* from produtos as p inner join promocao_diaria as s on s.id_produto = p.id_produto;";
          break;
        case 'ativos':
          $label = "Nossos Produtos";
          $query = "select * from produtos where situacao = 'A';";
          break;
      }
    }

    $res = $wpdb->get_results($query,ARRAY_A);
    if($res){
      echo "<h4>{$label}</h4>";
      echo "<div class='prod-list'>";
      $prod_qnt=0;
      foreach ($res as $key => $value) {
        ?>
          <div class='prod-box'>
            <table class='prod-table'>
              <?php
              if($instance['tipo_lista'] == 'promocao'){
                echo "<tr class='prod-columns'>";
                echo "<th class='prod-columns'>";
                echo "<Label>{$value['semana']}</Label>";
                echo "</th>";
                echo "</tr>";
              }
              ?>
              <tr class='prod-columns'>
                <th class='prod-columns'>
                  <img class='prod-image' src='https://www.receitasetemperos.com.br/wp-content/uploads/2019/02/Imagem-1copy.jpg'>
                </th>

              </tr>
              <tr>
                <td class='prod-columns'>
                  <a href='/wp-admin/admin.php?page=kidspay-crd-comprar'><Label class='prod-title'><?php echo $value['nome']?></Label></a>
                  <div class="kp-widget-item-action">
                    <span class="edit">
                      <a href="/wp-admin/admin.php?page=kidspay-cad-produtos&action=alt&id=<?php if(isset($value['id_produto'])) echo $value['id_produto']; else echo '0'?>">Editar</a>
                    </span>
                  </div>
                  <div><Label><?php echo $value['descricao']?></Label></div>
                  <?php
                    if($instance['tipo_lista'] == 'promocao'){
                      $valor = $value['valor'];
                    }else{
                      $valor = $value['preco_venda'];
                    }

                  ?>
                  <Label><?php echo "R$" . number_format(floatval($valor),2)?></Label>
                </td>
              <tr>
            </table>
          </div>
        <?php
        $prod_qnt++;
        if(isset($instance['qnt_itens'])){
          if($prod_qnt>=$instance['qnt_itens']){
            break;
          }
        }
      }
      echo "</div>";
    }
	}

	public function form( $instance ) {
    if ( isset( $instance[ 'tipo_lista' ] ) )
      $title = $instance[ 'tipo_lista' ];
    else
      $tipo = __( 'Escolher Tipo', 'kidspay' );
    ?>
    <table>
      <tr>
        <Label>Listar Produtos por:</Label>
      </tr>
      <tr>
        <?php
        $mais_vendas_checked = '';
        $promocao_checked = '';
        switch($instance['tipo_lista']){
          case 'mais_vendas':
            $mais_vendas_checked = 'selected';
            break;

          case 'promocao':
            $promocao_checked = 'selected';
            break;

          case 'ativos':
            $ativos_checked = 'selected';
            break;
        }
        ?>
      <select id="<?php echo $this->get_field_id( 'tipo_lista' ); ?>" name="<?php echo $this->get_field_name( 'tipo_lista' ); ?>">
        <option <?php echo $mais_vendas_checked?> value='mais_vendas'>Mais Vendidos</option>
        <option <?php echo $promocao_checked?> value='promocao'>Promoção do dia</option>
        <option <?php echo $ativos_checked?> value='ativos'>Produtos Ativos</option>
      </select>
      </tr>
      <tr>
        <Label>Quantidade de itens:</Label>
      </tr>
      <tr>
        <input type="number" id="<?php echo $this->get_field_id( 'qnt_itens' ); ?>" name="<?php echo $this->get_field_name( 'qnt_itens' ); ?>"  value="<?php echo $instance['qnt_itens']; ?>">
      </tr>

    <?php
	}

	public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['tipo_lista'] = ( ! empty( $new_instance['tipo_lista'] ) ) ? strip_tags( $new_instance['tipo_lista'] ) : '';
    $instance['qnt_itens'] = ( ! empty( $new_instance['qnt_itens'] ) ) ? strip_tags( $new_instance['qnt_itens'] ) : '';

    return $instance;

	}
}

add_action('widgets_init',function(){register_widget('ProdutosWidgets');});
