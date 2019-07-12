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

if ( ! class_exists( 'Foodie_Japan_Woocommerce' ) ) :

class Foodie_Japan_Woocommerce {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    // remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    add_filter( 'woocommerce_checkout_fields', array( $this, 'override_checkout_fields' ) );
    add_action( 'wp_footer', array( $this, 'hide_empty_cart' ) );
    add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_images_slider'), 20 );
  }

  /**
   * Unset billing
   * @return void
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
   * @return void
   */
  public function hide_empty_cart() {
    if ( WC()->cart->get_cart_contents_count() == 0 ) {
      ?>
      <style type="text/css">#site-header-cart{display: none;}</style>
      <?php
    }
  }

  /**
   * Image single product
   * @return void
   */
  public function product_images_slider() {
    global $product;
    $gallery_images = $product->get_gallery_image_ids();

    echo '<div class="product-media"><ul class="product-slider hidden">';
      foreach ($gallery_images as $attachment_id) {
        echo'<li><div class="product-photo">';
          echo wp_get_attachment_image($attachment_id, 'photo-slider', false, array('title' => get_the_title($attachment_id)));
        echo '</div></li>';
      }
    echo '</ul></div>';
  }
}

endif;

return new Foodie_Japan_Woocommerce();
