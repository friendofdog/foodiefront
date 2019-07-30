<?php

/**
 * Foodie Japan Header
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'Foodie_Japan_Header' ) ) :

class Foodie_Japan_Header {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    add_action( 'wp', array( $this, 'header_adjustments' ) );
    add_action( 'widgets_init', array( $this, 'add_preheader_text' ) );
  }

  /**
   * Header adjustments
   * @return void
   */
  public function header_adjustments() {
    remove_action( 'storefront_header', 'storefront_site_branding', 20);
    remove_action( 'storefront_header', 'storefront_product_search', 40);
    remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );

    add_action( 'storefront_header', 'display_preheader_text', 25);
    add_action( 'storefront_header', 'storefront_site_branding', 45);
    add_action( 'storefront_header', 'display_header_bottom', 70);

    /**
     * Render preheader text
     * @return string
     */
    function display_preheader_text() {
      if ( is_active_sidebar( 'preheader_text' ) ) : ?>
        <div id="preheader-text" class="preheader-text" role="complementary">
          <?php dynamic_sidebar( 'preheader_text' ); ?>
        </div>
      <?php endif;
    }

    /**
     * Render peader bottom
     * @return string
     */
    function display_header_bottom() {
      ?>
      <div class="header-bottom">
        <div></div>
      </div>
      <?php
    }
  }

  /**
   * Preheader text widget
   * @return void
   */
  public function add_preheader_text() {
    register_sidebar( array(
      'name' => 'Preheader text',
      'id' => 'preheader_text',
      'before_widget' => '<div>',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    ) );
  }
}

endif;

return new Foodie_Japan_Header();
