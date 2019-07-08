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

    add_action( 'wp_enqueue_scripts', array( $this, 'styles_scripts_init' ), 30 );
    add_action( 'wp_enqueue_scripts', array( $this, 'customizer_styling_init' ), 150 );
    add_action( 'wp_enqueue_scripts', array( $this, 'siteorigin_panels_remove_inline_css'), 11 );
    add_action( 'init', array( $this, 'custom_post_types_init' ) );
    add_action( 'init', array( $this, 'custom_image_size_init' ) );
  }

  /**
   * Dequeue styles
   * @return void
   */
  public function styles_scripts_init() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'storefront-gutenberg-blocks' );
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
    wp_dequeue_style( 'storefront-child-style' );
    wp_dequeue_style( 'storefront-woocommerce-bookings-style' );

    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/scripts.min.js', '', '', true);
  }

  /**
   * Customizer styling
   * @return void
   */
  public function customizer_styling_init() {
    $inline_style = WP_Styles()->registered['storefront-style']->extra['after'][0];
    wp_register_style( 'customizer-style', false );
    wp_enqueue_style( 'customizer-style' );
    wp_add_inline_style( 'customizer-style', $inline_style );
  }

  /**
   * Siteorigin styling
   * @return void
   */
  public function siteorigin_panels_remove_inline_css(){
    $renderer = SiteOrigin_Panels_Renderer::single();
    remove_action( 'wp_head', array( $renderer, 'print_inline_css' ), 12 );
    remove_action( 'wp_footer', array( $renderer, 'print_inline_css' ) );
  }

  /**
   * Custom post types
   * @return void
   */
  public function custom_post_types_init() {
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

  /**
   * Image sizes
   * @return void
   */
  public function custom_image_size_init() {
    add_image_size( 'hero-banner', 1800, 600, array( 'center', 'center' ) );
  }
}

endif;

return new Foodie_Japan_Site();
