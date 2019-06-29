<?php

// remove emoji stuff from header
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// disable Gutenberg
add_filter( 'use_block_editor_for_post', '__return_false' );


require_once( 'inc/class-fj.php' );

/* WooCommerce
 ========================================================================== */

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

add_filter( 'woocommerce_checkout_fields' , 'fj_override_checkout_fields' );

function fj_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);
  return $fields;
}

// add_action( 'wp_footer', 'fj_hide_cart' );

function fj_hide_cart() {
  if ( WC()->cart->get_cart_contents_count() == 0 ) {
    ?>
    <style type="text/css">#site-header-cart{display: none;}</style>
    <?php
  }
}


/* Yoast
 ========================================================================== */

add_filter( 'manage_edit-product_columns', 'fj_yoast_admin_remove_columns', 10, 1 );

function fj_yoast_admin_remove_columns( $columns ) {
  unset($columns['wpseo-score']);
  unset($columns['wpseo-score-readability']);
  unset($columns['wpseo-title']);
  unset($columns['wpseo-metadesc']);
  unset($columns['wpseo-focuskw']);
  unset($columns['wpseo-links']);
  unset($columns['wpseo-linked']);
  return $columns;
}


/* Custom post types
 ========================================================================== */

// custom post type - press
add_action( 'init', 'fj_press_custom_init' );

function fj_press_custom_init() {
  $args = array(
    'public'                => true,
    // 'taxonomies'            => array( 'category' ),
    'label'                 => 'Press',
    'position'              => '20.4',
    'exclude_from_search'   => false,
    'menu_icon'             => 'dashicons-megaphone',
    'has_archive'           => false,
    'publicly_queryable'    => false,
    'supports'              => array('page-attributes', 'editor', 'title'),
  );

  register_post_type( 'press', $args );
}


/* CF7
 ========================================================================== */
// allow default values in shortcode
add_filter( 'shortcode_atts_wpcf7', 'fj_custom_shortcode_atts_wpcf7_filter', 10, 3 );

function fj_custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
    $tour_title = 'tour-title';

    if ( isset( $atts[$tour_title] ) ) {
        $out[$tour_title] = $atts[$tour_title];
    }

    return $out;
}
