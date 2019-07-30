<?php

/**
 * Foodie Japan WooCommerce
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( class_exists( 'WC_Bookings_Data' ) ) :

if ( ! class_exists( 'Foodie_Japan_Woocommerce' ) ) :

class Foodie_Japan_Woocommerce extends WC_Bookings_Data {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

    add_filter( 'woocommerce_checkout_fields', array( $this, 'override_checkout_fields' ) );
    add_filter( 'booking_form_fields', array( $this, 'custom_order_booking_fields') );

    add_action( 'template_redirect', array( $this, 'disable_woocommerce_css_js' ), 999 );
    add_action( 'init', array( $this, 'remove_storefront_handheld_footer_bar' ) );
    add_action( 'wp_footer', array( $this, 'hide_empty_cart' ) );
  }

  /**
   * Dequeue WooCommerce assets on all pages except cart and checkout
   * @return object
   */
  public function disable_woocommerce_css_js() {
    if ( function_exists( 'is_woocommerce' ) ) {
      if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
        remove_action( 'wp_enqueue_scripts', [WC_Frontend_Scripts::class, 'load_scripts'] );
        remove_action( 'wp_print_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5 );
  	    remove_action( 'wp_print_footer_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5 );
      }
    }
  }

  /**
   * Remove footer bar
   * @return object
   */
  function remove_storefront_handheld_footer_bar() {
    remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
  }

  /**
   * Reorder booking fields
   * @param  object $fields
   * @return object
   */
  public function custom_order_booking_fields( $fields ) {
    $product = wc_get_product();

    if ($product) :
      $persons = $product->get_person_types();

    	$reorder  = array();
      if ($fields['wc_bookings_field_start_date'])
        $reorder[] = $fields['wc_bookings_field_start_date'];
      if ($persons) :
        foreach (array_keys($persons) as $person) :
          $reorder[] = $fields['wc_bookings_field_persons_' . $person];
        endforeach;
      endif;
      if ($fields['wc_bookings_field_resource'])
        $reorder[] = $fields['wc_bookings_field_resource'];
    	return $reorder;
    endif;
  }

  /**
   * Unset billing
   * @param  object $fields
   * @return object
   */
  public function override_checkout_fields( $fields ) {
   unset($fields['billing']['billing_company']);
   unset($fields['billing']['billing_address_1']);
   unset($fields['billing']['billing_address_2']);
   unset($fields['billing']['billing_city']);
   unset($fields['billing']['billing_postcode']);
   unset($fields['billing']['billing_country']);
   unset($fields['billing']['billing_state']);
   return $fields;
  }

  /**
   * Hide empty cart
   * @return string
   */
  public function hide_empty_cart() {
    if ( WC()->cart->get_cart_contents_count() == 0 ) {
      ?>
      <style type="text/css">#site-header-cart{display: none;}</style>
      <?php
    }
  }
}

endif;

return new Foodie_Japan_Woocommerce();

endif;
