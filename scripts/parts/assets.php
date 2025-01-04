<?php
function arsol_dijital_project_theme_scripts() {
  $version='1.0';    
  wp_enqueue_style( 'set-site-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap', array(), $version, 'all');
  wp_enqueue_style( 'ars-set-bootstrap.css', get_template_directory_uri() . '/assets/plugins/bootstrap/css/bootstrap.min.css', array(), $version, 'all');
  wp_enqueue_style( 'ars-set-bootstrap-icon.css', get_template_directory_uri() . '/assets/plugins/bootstrap/font/bootstrap-icons.min.css', array(), $version, 'all');
  wp_enqueue_style( 'ars-set-app.css', get_template_directory_uri() . '/assets/css/app.min.css', array(), $version, 'all');
  wp_enqueue_style( 'ars-set-last.css', get_template_directory_uri() . '/assets/css/last.css', array(), $version, 'all');
  /*JS*/
  wp_enqueue_script( 'ars-set-jquery.js',get_template_directory_uri().'/assets/js/jquery-3.7.1.min.js',array( 'jquery' ),$version,true);
  wp_enqueue_script( 'ars-set-bootstrap.js',get_template_directory_uri().'/assets/plugins/bootstrap/js/bootstrap.bundle.min.js',array( 'jquery' ),$version,true);
  wp_enqueue_script( 'ars-set-last.js',get_template_directory_uri().'/assets/js/last.js',array( 'jquery' ),$version,true);
  $uyelik_js_paramater = array(
    'ajaxURL' => admin_url( 'admin-ajax.php' ),
  );  
  wp_add_inline_script( 'ars-set-last.js', 'var send_data = ' . wp_json_encode( $uyelik_js_paramater ), 'before' );
}
add_action( 'wp_enqueue_scripts', 'arsol_dijital_project_theme_scripts' );