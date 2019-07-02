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

if ( ! class_exists( 'Foodie_Japan_Woo' ) ) :

class Foodie_Japan_Woo {
    /**
     * Setup class.
     *
     * @since 1.0
     */
    public function __construct() {
      remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
      remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
      add_filter( 'woocommerce_checkout_fields' , 'fj_override_checkout_fields' );
    }

    /**
     * Layout adjustments
     * @return rearrange markup through add_action and remove_action
     */
     public function fj_override_checkout_fields( $fields ) {
       unset($fields['billing']['billing_company']);
       unset($fields['billing']['billing_address_1']);
       unset($fields['billing']['billing_address_2']);
       unset($fields['billing']['billing_city']);
       unset($fields['billing']['billing_postcode']);
       unset($fields['billing']['billing_country']);
       unset($fields['billing']['billing_state']);
       return $fields;
     }
}

endif;

return new Foodie_Japan_Woo();
