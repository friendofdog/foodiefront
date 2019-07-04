<?php

/**
 * Foodie Japan
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Foodie_Japan_Site' ) ) :

class Foodie_Japan_Site {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    // remove emoji stuff from header
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    // disable Gutenberg editor
    add_filter( 'use_block_editor_for_post', '__return_false' );

    add_action( 'wp_enqueue_scripts', array( $this, 'remove_unneeded_styles' ), 30 );
    add_action( 'wp_enqueue_scripts', array( $this, 'fj_enqueue_minified_scripts' ), 30 );
    add_action( 'wp_enqueue_scripts', array( $this, 'extract_storefront_inline' ), 150 );
    add_action( 'init', array( $this, 'fj_press_custom_init' ) );
  }

  /**
   * Dequeue styles
   * @return remove unneded styles
   */
  public function remove_unneeded_styles() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'storefront-gutenberg-blocks' );
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
    wp_dequeue_style( 'storefront-child-style' );
    wp_dequeue_style( 'storefront-woocommerce-bookings-style' );
  }

  public function fj_enqueue_minified_scripts() {
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/scripts.min.js');
  }

  public function fj_press_custom_init() {
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

  public function extract_storefront_inline() {
    $inline_style = WP_Styles()->registered['storefront-style']->extra['after'][0];
    wp_register_style( 'customizer-style', false );
    wp_enqueue_style( 'customizer-style' );
    wp_add_inline_style( 'customizer-style', $inline_style );
  }
}

endif;

return new Foodie_Japan_Site();
