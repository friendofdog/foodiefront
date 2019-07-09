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
    add_action( 'get_header', array( $this, 'remove_storefront_sidebar' ) );
    add_action( 'widgets_init', array( $this, 'add_preheader_text' ) );
  }

  /**
   * Header adjustments
   * @return void
   */
  public function header_adjustments() {
    function preheader_text() {
      if ( is_active_sidebar( 'preheader_text' ) ) : ?>
      	<div id="preheader-text" class="preheader-text" role="complementary">
      		<?php dynamic_sidebar( 'preheader_text' ); ?>
      	</div>
      <?php endif;
    }

    function header_bottom() {
      ?>
      <div class="header-bottom">
        <div></div>
      </div>
      <?php
    }

    remove_action( 'storefront_header', 'storefront_site_branding', 20);
    remove_action( 'storefront_header', 'storefront_product_search', 40);

    add_action( 'storefront_header', 'preheader_text', 25);
    add_action( 'storefront_header', 'storefront_site_branding', 45);
    add_action( 'storefront_header', 'header_bottom', 70);
  }

  /**
   * Sidebars
   * @return void
   */
  public function remove_storefront_sidebar() {
    remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
  }

  /**
   * Preheader text
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
