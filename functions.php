<?php

function kp_admin_registrar_assets(){

  wp_enqueue_script('jquery_kidspay', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);

  wp_register_style( 'estilos_forms', plugins_url( '/assets/css/forms.css' , __FILE__ ) );
  wp_enqueue_style(  'estilos_forms', plugins_url( '/assets/css/forms.css' , __FILE__ )  );

  wp_localize_script( 'scripts_forms', 'scripts_forms', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );

  wp_register_script( 'scripts_forms', plugins_url( '/assets/js/forms.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_forms', plugins_url( '/assets/js/forms.js' , __FILE__ )  );

  wp_register_script( 'scripts_graficos', plugins_url( '/assets/js/graficos.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_graficos', plugins_url( '/assets/js/graficos.js' , __FILE__ )  );

  wp_register_script( 'scripts_consultas', plugins_url( '/assets/js/consultas.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_consultas', plugins_url( '/assets/js/consultas.js' , __FILE__ )  );
/*
  if(isset($_REQUEST['kidspay_pagamento']))
    wp_enqueue_script('pagseguro_kidspay', SCRIPT_PAGSEGURO , array(), null, true);
  wp_enqueue_script('pagseguro_kidspay_pagamento', plugins_url('/src/api/pagseguro/js/personalizado.js' , __FILE__) , array(), null, true);
*/
}

function kp_registrar_assets(){
  wp_enqueue_script('jquery_kidspay', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);

  wp_register_style( 'estilos_widgets', plugins_url( '/assets/css/widgets.css' , __FILE__ ) );
  wp_enqueue_style(  'estilos_widgets', plugins_url( '/assets/css/widgets.css' , __FILE__ )  );

  wp_register_script( 'scripts_consultas', plugins_url( '/assets/js/consultas.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_consultas', plugins_url( '/assets/js/consultas.js' , __FILE__ )  );
}

add_action('admin_enqueue_scripts', 'kp_admin_registrar_assets');
add_action('wp_enqueue_scripts', 'kp_registrar_assets');
