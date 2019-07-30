<?php

/**
 * Require plugins
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Foodie_Japan_Require_Plugins' ) ) :

class Foodie_Japan_Require_Plugins {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
  }

  /**
   * Require plugins
   * @return null
   */
  public function register_required_plugins() {
    $plugins = array(
      array(
        'name'               => 'Advanced Custom Fields Pro',
        'slug'               => 'advanced-custom-fields-pro',
        'source'             => get_stylesheet_directory() . '/lib/advanced-custom-fields-pro.zip',
        'required'           => true,
        'version'            => '5.8.0',
        'force_activation'   => false,
        'force_deactivation' => false
      ),
      array(
        'name'               => 'ACF Repeater',
        'slug'               => 'acf-repeater',
        'source'             => get_stylesheet_directory() . '/lib/acf-repeater.zip',
        'required'           => true,
        'version'            => '2.1.0',
        'force_activation'   => false,
        'force_deactivation' => false
      ),
      array(
        'name'               => 'WooCommerce',
        'slug'               => 'woocommerce',
        'source'             => get_stylesheet_directory() . '/lib/woocommerce.3.6.5.zip',
        'required'           => true,
        'version'            => '3.6.5',
        'force_activation'   => true,
        'force_deactivation' => false
      ),
      array(
        'name'               => 'WooCommerce Bookings',
        'slug'               => 'woocommerce-bookings',
        'source'             => get_stylesheet_directory() . '/lib/woocommerce-bookings.zip',
        'required'           => true,
        'version'            => '1.14.5',
        'force_activation'   => true,
        'force_deactivation' => false
      ),
      array(
        'name'               => 'Yoast SEO',
        'slug'               => 'wordpress-seo',
        'is_callable'        => 'wpseo_init',
        'required'           => false,
        'version'            => '11.0'
      )
    );
    tgmpa( $plugins, $config );
  }
}

endif;

return new Foodie_Japan_Require_Plugins();
