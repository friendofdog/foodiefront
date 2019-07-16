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

    add_filter( 'woocommerce_checkout_fields', array( $this, 'override_checkout_fields' ) );
    add_filter( 'booking_form_fields', array( $this, 'custom_order_booking_fields') );

    add_action( 'wp_footer', array( $this, 'hide_empty_cart' ) );
    add_action( 'woocommerce_before_single_product_summary', array( $this, 'create_tour_summary'), 10 );
    add_action( 'woocommerce_before_single_product_summary', array( $this, 'create_product_main_content'), 20 );
    add_action( 'product_main_content', array( $this, 'product_images_slider'), 10 );
    add_action( 'product_main_content', 'woocommerce_template_single_excerpt' );
  }

  /**
   * Reorder booking fields
   * @param  object $fields
   * @return object
   */
  public function custom_order_booking_fields ( $fields ) {
    $product = wc_get_product();
    $persons = $product->get_person_types();

  	$reorder  = array();
    if ($fields['wc_bookings_field_start_date'])
      $reorder[] = $fields['wc_bookings_field_start_date'];
    if ($persons) : foreach (array_keys($persons) as $person) :
      $reorder[] = $fields['wc_bookings_field_persons_' . $person];
    endforeach; endif;
    if ($fields['wc_bookings_field_resource'])
      $reorder[] = $fields['wc_bookings_field_resource'];
  	return $reorder;
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

  /**
   * Product main content
   * @return string
   */
  public function create_tour_summary() {
    ?>
    <div class="tour-summary">
      qwer
    </div>
    <?php
  }

  /**
   * Product main content
   * @return string
   */
  public function create_product_main_content() {
    global $product;
    $gallery_images = $product->get_gallery_image_ids();

    ?>
    <div class="product-main-content">
      <?php do_action('product_main_content'); ?>
    </div>
    <?php
  }

  /**
   * Product media slider
   * @return string
   */
  public function product_images_slider() {
    global $product;
    $gallery_images = $product->get_gallery_image_ids();

    ?>
    <div class="product-slider-wrapper">
      <ul class="product-slider hidden">
        <?php foreach ($gallery_images as $index => $attachment_id) {
          $terminal = '';
          $terminal = $index === 0 ? 'photo-first' : $terminal;
          $terminal = $index === count($gallery_images) - 1 ? 'photo-last' : $terminal;

          ?>
          <li class="<?php echo $terminal; ?>"><div class="product-photo">
            <?php echo wp_get_attachment_image($attachment_id, 'photo-slider', false, array('title' => get_the_title($attachment_id))); ?>
          </div></li>
          <?php
        } ?>
      </ul>
    </div>
    <?php
  }
}

endif;

return new Foodie_Japan_Woocommerce();
