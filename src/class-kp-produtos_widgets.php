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
      $tipo_lista = apply_filters('widget_title', $instance['tipo_lista']);

    if(isset($instance['qnt_itens']))
      $qnt_itens = apply_filters('widget_title', $instance['qnt_itens']);

    if(isset($instance['imagem_obgtr']))
      $imagem_obgtr = apply_filters('widget_title', $instance['imagem_obgtr']);

    $label = '';
    $query = '';
    if ( ! empty( $tipo_lista ) ){
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
          $label = "<h3>Nossos Produtos</h3>";
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
        if($instance['imagem_obgtr']){
          if(!$value['image_path'] or !strlen($value['image_path'])){
            continue;
          }
        }
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
                  <img class='prod-image' src='<?php if(isset($value['image_path'])) echo $value['image_path']; else echo 'noimage' ?>'>
                </th>

              </tr>
              <tr>
                <td class='prod-columns'>
                  <a href='/wp-admin/admin.php?page=kidspay-crd-comprar'><Label class='prod-title'><?php echo ucfirst($value['nome'])?></Label></a>
                  <?php add_thickbox(); ?>
                  <a style='color:red;' class="thickbox" href="/wp-admin/admin.php?page=kidspay-cad-produtos&action=alt&id=<?php if(isset($value['id_produto'])) echo $value['id_produto']; else echo '0'?>TB_iframe=true&width=800&height=500">Editar</a>
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
    }else{
      switch ($instance['tipo_lista']) {

        case 'mais_vendas':
          if(current_user_can('manage_options')){
            echo 'Ainda não há produtos vendidos';
          }
          break;

        case 'promocao':
          if(current_user_can('manage_options')){
            echo 'Sem promoção diária cadastrada';
          }
          break;

        case 'ativos':
          echo "Sem produtos no momento";
          break;
      }
    }
	}

	public function form( $instance ) {
    ?>

    <table class="form-table">
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
        <td>
        <Label>Quantidade máxima de itens:</Label>
        <input type="number" id="<?php echo $this->get_field_id( 'qnt_itens' ); ?>" name="<?php echo $this->get_field_name( 'qnt_itens' ); ?>"  value="<?php echo $instance['qnt_itens']; ?>">
      </tr>
      <tr>
        <Label for="imagem_obgtr">Postar apenas produtos com imagem: </Label>
        <input
        id="<?php echo $this->get_field_id( 'imagem_obgtr' );?>"
        name="<?php echo $this->get_field_name( 'imagem_obgtr' );?>"
        type='checkbox'
          <?php
          if(isset($instance['imagem_obgtr'])){
            if($instance['imagem_obgtr'])
              echo 'checked';
          }
          ?>>

      </tr>

    <?php
	}

	public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['imagem_obgtr'] = ( ! empty( $new_instance['imagem_obgtr'] ) ) ? strip_tags( $new_instance['imagem_obgtr'] ) : '';
    $instance['tipo_lista'] = ( ! empty( $new_instance['tipo_lista'] ) ) ? strip_tags( $new_instance['tipo_lista'] ) : '';
    $instance['qnt_itens'] = ( ! empty( $new_instance['qnt_itens'] ) ) ? strip_tags( $new_instance['qnt_itens'] ) : '';

    return $instance;

	}
}

add_action('widgets_init',function(){register_widget('ProdutosWidgets');});
