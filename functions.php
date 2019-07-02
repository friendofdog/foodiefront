<?php

// remove emoji stuff from header
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// disable Gutenberg
add_filter( 'use_block_editor_for_post', '__return_false' );

require_once( 'inc/class-fj.php' );
require_once( 'inc/class-woocommerce.php' );







/* Storefront
 ========================================================================== */
add_action( 'wp_enqueue_scripts', 'add_fontawesome_kit', 100 );

function add_fontawesome_kit() {
    wp_register_script( 'fa-kit', 'https://kit.fontawesome.com/4861f2b45b.js', array( 'jquery' ) , '5.9.0', true ); // -- From an External URL
    wp_enqueue_script( 'fa-kit' );
}


/* WooCommerce
 ========================================================================== */

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
