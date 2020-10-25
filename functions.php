<?php

function kp_admin_registrar_assets(){

  wp_register_style( 'estilos_forms', plugins_url( '/assets/css/forms.css' , __FILE__ ) );
  wp_enqueue_style(  'estilos_forms', plugins_url( '/assets/css/forms.css' , __FILE__ )  );

  wp_localize_script( 'scripts_forms', 'scripts_forms', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );

  wp_register_script( 'scripts_forms', plugins_url( '/assets/js/forms.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_forms', plugins_url( '/assets/js/forms.js' , __FILE__ )  );

  wp_register_script( 'scripts_graficos', plugins_url( '/assets/js/graficos.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_graficos', plugins_url( '/assets/js/graficos.js' , __FILE__ )  );

}

function kp_registrar_assets(){
  wp_register_style( 'estilos_widgets', plugins_url( '/assets/css/widgets.css' , __FILE__ ) );
  wp_enqueue_style(  'estilos_widgets', plugins_url( '/assets/css/widgets.css' , __FILE__ )  );
}

add_action('admin_enqueue_scripts', 'kp_admin_registrar_assets');
add_action('wp_enqueue_scripts', 'kp_registrar_assets');
