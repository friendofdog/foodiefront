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

    add_filter( 'use_block_editor_for_post', '__return_false' );
    add_filter( 'is_active_sidebar', array( $this, 'product_remove_sidebar'), 10, 2 );

    add_action( 'wp_enqueue_scripts', array( $this, 'styles_scripts_init' ), 30 );
    add_action( 'wp_enqueue_scripts', array( $this, 'customizer_styling_init' ), 150 );
    add_action( 'wp_enqueue_scripts', array( $this, 'siteorigin_panels_remove_inline_css'), 11 );
    add_action( 'init', array( $this, 'custom_image_size_init' ) );
    add_action( 'foodiefront_before_content', array( $this, 'blog_page_add_header' ) );
    add_action( 'storefront_after_footer', array( $this, 'scroll_to_top' ), 10 );
  }

  /**
   * Remove sidebar from product page
   * @return boolean
   */
  function product_remove_sidebar( $is_active_sidebar, $index ) {
    if( $index !== "sidebar-1" ) {
      return $is_active_sidebar;
    }
    if( ! is_product() ) {
      return $is_active_sidebar;
    }
    return false;
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
   * Image sizes
   * @return void
   */
  public function custom_image_size_init() {
    add_image_size( 'photo-slider', 690, 460, array( 'center', 'center' ) );
  }

  /**
   * Blog page header
   * @return string
   */
  public function blog_page_add_header() {
    if ( 'post' === get_post_type() ) {
      ?>
      <header class="page-header">
        <?php echo single_post_title( '<h1 class="page-title">', '</h1>' ); ?>
      </header><!-- .page-header -->
      <?php
    }
  }

  /**
   * Back to top
   * @return string
   */
  public function scroll_to_top() {
    ?>
    <a class="top-link hidden" href="" id="js-top">
      <i class="fas fa-chevron-up"></i>
    </a>
    <?php
  }
}

endif;

return new Foodie_Japan_Site();
