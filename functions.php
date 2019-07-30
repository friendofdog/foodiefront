<?php

require_once( 'inc/foodie-template-functions.php' );
require_once( 'inc/vendors/class-tgm-plugin-activation.php' );
require_once( 'inc/vendors/aq_resizer.php' );
require_once( 'inc/class-plugins.php' );
require_once( 'inc/class-foodie-japan.php' );
require_once( 'inc/class-header.php' );
require_once( 'inc/class-hero-banner.php' );
require_once( 'inc/class-woocommerce.php' );
require_once( 'inc/class-yoast.php' );
// require_once( 'inc/class-contact.php' );

// add_action( 'wp_print_scripts', 'inspect_scripts' );
function inspect_scripts() {
  global $wp_scripts;
  echo '<pre>';
  print_r($wp_scripts->queue);
  echo '</pre>';
}

// add_action( 'wp_print_styles', 'inspect_styles' );
function inspect_styles() {
  global $wp_styles;
  echo '<pre>';
  print_r($wp_styles->queue);
  echo '</pre>';
}

// add_action('wp', 'get_all_image_sizes');
function get_all_image_sizes(){
    global $_wp_additional_image_sizes;
    print '<pre>';
    print_r( $_wp_additional_image_sizes );
    print '</pre>';
}
