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
   * @return rearrange header

   * Functions hooked into storefront_header action
   *
   * @hooked storefront_header_container                 - 0
   * @hooked storefront_skip_links                       - 5
   * @hooked storefront_social_icons                     - 10
   * @hooked storefront_site_branding                    - 20
   * @hooked storefront_secondary_navigation             - 30
   * @hooked storefront_product_search                   - 40
   * @hooked storefront_header_container_close           - 41
   * @hooked storefront_primary_navigation_wrapper       - 42
   * @hooked storefront_primary_navigation               - 50
   * @hooked storefront_header_cart                      - 60
   * @hooked storefront_primary_navigation_wrapper_close - 68
   */

  public function header_adjustments() {
    function fj_preheader_text() {
      if ( is_active_sidebar( 'preheader_text' ) ) : ?>
      	<div id="preheader-text" class="preheader-text" role="complementary">
      		<?php dynamic_sidebar( 'preheader_text' ); ?>
      	</div>
      <?php endif;
    }

    function fj_preheader() {
      echo '<div class="fj-preheader">';
    }

    function fj_preheader_close() {
      echo '</div>';
    }

  	function fj_primary_navigation_wrapper() {
  		echo '<div class="storefront-primary-navigation">';
  	}

    function fj_primary_navigation_wrapper_close() {
      echo '</div>';
    }

    remove_action( 'storefront_header', 'storefront_header_container', 0);
    remove_action( 'storefront_header', 'storefront_site_branding', 20);
    remove_action( 'storefront_header', 'storefront_product_search', 40);
    remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper', 42);
    remove_action( 'storefront_header', 'storefront_header_container_close', 41 );
    remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close', 68);

    add_action( 'storefront_header', 'fj_preheader', 0);
    add_action( 'storefront_header', 'fj_preheader_text', 25);
    add_action( 'storefront_header', 'fj_preheader_close', 40);
    add_action( 'storefront_header', 'fj_primary_navigation_wrapper', 42);
    add_action( 'storefront_header', 'storefront_site_branding', 45);
    add_action( 'storefront_header', 'fj_primary_navigation_wrapper_close', 68);
  }

  /**
   * Sidebars
   * @return remove Storefront sidebar, add preheader sidebar
   */
  public function remove_storefront_sidebar() {
    remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
  }

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
