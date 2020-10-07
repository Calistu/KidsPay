<?php

function registrar_assets(){
  wp_register_style( 'estilos_forms', plugins_url( '/assets/css/forms.css' , __FILE__ ) );
  wp_enqueue_style( 'estilos_forms', plugins_url( '/assets/css/forms.css' , __FILE__ )  );

  wp_register_script( 'scripts_forms', plugins_url( '/assets/js/cad_alunos.js' , __FILE__ ) );
  wp_enqueue_script( 'scripts_forms', plugins_url( '/assets/js/cad_alunos.js' , __FILE__ )  );

  wp_localize_script( 'scripts_forms', 'scripts_forms', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('admin_enqueue_scripts', 'registrar_assets');
