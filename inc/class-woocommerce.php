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
    add_action( 'acf/init', array( $this, 'create_product_acf_fields' ) );
    add_action( 'wp_footer', array( $this, 'hide_empty_cart' ) );
    add_action( 'woocommerce_before_single_product_summary', array( $this, 'create_product_page_before_content'), 10 );
    add_action( 'woocommerce_before_single_product_summary', array( $this, 'create_product_main_content'), 20 );
    add_action( 'woocommerce_after_single_product_summary', array( $this, 'create_product_page_after_content'), 10 );
    add_action( 'product_main_content', array( $this, 'product_images_slider'), 10 );
    add_action( 'product_main_content', array( $this, 'create_product_tour_details'), 20 );
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

  /**
   * Product page header
   * @return string
   */
  public function create_product_page_before_content() {
    ?>
    <h1 class="page-title"><?php the_title(); ?></h1>
    <div id="product-content-wrapper" class="product-content-wrapper">
    <?php
  }

  /**
   * Product page header
   * @return string
   */
  public function create_product_page_after_content() {
    ?>
    </div></div></div>
    <?php
  }

  /**
   * Create ACF fields for product
   * @return null
   */
  public function create_product_acf_fields() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
    	'key' => 'bookings',
    	'title' => 'Bookings',
    	'fields' => array (
    		array (
    			'key' => 'overview',
    			'label' => 'Overview',
    			'name' => 'overview',
    			'type' => 'wysiwyg',
          'required' => 1,
          'tabs' => 'all',
          'toolbar' => 'basic',
          'media_upload' => 0
    		),
        array (
          'key' => 'location',
          'label' => 'Location',
          'name' => 'location',
          'type' => 'text',
          'required' => 1,
        ),
        array (
          'key' => 'included',
          'label' => 'Included',
          'name' => 'included',
          'type' => 'wysiwyg',
          'required' => 0,
          'tabs' => 'text',
          'toolbar' => 'basic',
          'media_upload' => 0
        ),
        array (
          'key' => 'not_included',
          'label' => 'Not included',
          'name' => 'not_included',
          'type' => 'wysiwyg',
          'required' => 0,
          'tabs' => 'text',
          'toolbar' => 'basic',
          'media_upload' => 0
        )
    	),
    	'location' => array (
    		array (
    			array (
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'product',
    			),
    		),
    	),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => array('the_content'),
    ));

    endif;
  }

  /**
   * Product summary
   * @return string
   */
  public function create_product_tour_details() {
    $product = wc_get_product();

    if ( $product && class_exists('ACF') ) :

    /**
     * Returns an array of bookable products according to supplied criteria
     * @return string
     */
    function display_tour_availabilities( $product ) {
      $availabilities = $product->get_availability( 'view' );
      $schedule = array(
        'time:1' => array(
          'name' => 'Monday',
          'times' => array()
        ),
        'time:2' => array(
          'name' => 'Tuesday',
          'times' => array()
        ),
        'time:3' => array(
          'name' => 'Wednesday',
          'times' => array()
        ),
        'time:4' => array(
          'name' => 'Thursday',
          'times' => array()
        ),
        'time:5' => array(
          'name' => 'Friday',
          'times' => array()
        ),
        'time:6' => array(
          'name' => 'Saturday',
          'times' => array()
        ),
        'time:7' => array(
          'name' => 'Sunday',
          'times' => array()
        )
      );

      usort( $availabilities, function($a, $b) {
        $name = strcmp($b['bookable'], $a['bookable']);
        if ($name === 0) {
          return $a['from'] - $b['from'];
        }
        return $name;
      } );

      foreach ($availabilities as $availability) {
        $day_code = $availability['type'];
        $day_single = $schedule[$day_code]['times'];
        $bookable = $availability['bookable'];
        $timeslot = $availability['from'] . '~' . $availability['to'];

        if ($bookable === 'yes') {
          if ($day_code === 'time') {
            foreach ($schedule as $day_key => $day_value) {
              if (!in_array($timeslot, $schedule[$day_key]['times']))
                $today = array_push($schedule[$day_key]['times'], $timeslot);
            }
          } elseif (array_key_exists($day_code, $schedule)) {
            if (!in_array($timeslot, $day_single))
              array_push($schedule[$day_code]['times'], $timeslot);
          }
        } else if ($bookable === 'no') {
          $key = array_search($timeslot, $day_single);
          if (false !== $key) {
            unset($schedule[$day_code]['times'][$key]);
          }
        }
      }

      return $schedule;
    }

    $schedule = display_tour_availabilities( $product );
    $separator = __( ':' , 'punctuation' ) . str_repeat( '&nbsp;', 1 );

    ?>

    <div class="product-tour-wrapper">
      <div class="product-tour">
        <div class="tour-header text-center">
          <?php _e( 'Click below for the tasty details', 'woocommerce-bookings' ) ?>
        </div>
        <div class="tour-switcher-wrapper">
          <div class="tour-switcher">
            <a class="tour-trigger active" href="#" data-target="tour-details">
              <?php _e( 'Details', 'woocommerce-bookings' ); ?>
            </a>
            <a class="tour-trigger" href="#" data-target="tour-overview">
              <?php _e( 'Overview', 'woocommerce-bookings' ); ?>
            </a>
          </div>
        </div>
        <div class="tour-content-wrapper">
          <div id="tour-details" class="tour-content">
            <?php
            $persons = $product->get_person_types();
            if ($persons) :
              ?>
              <div class="detail-item">
                <h4><?php esc_html_e( 'Price' , 'woocommerce-bookings' ); ?></h4>
                <?php
                foreach (array_keys($persons) as $person) :
                  ?><span><?php
                  $person_type = new WC_Product_Booking_Person_Type( $person );
                  echo $person_type->get_name() . $separator . $person_type->get_description();
                  ?></span><br><?php
                endforeach;
                ?>
              </div>
            <?php endif; ?>
            <?php if (get_field('location')) : ?>
            <div class="detail-item">
              <h4><?php esc_html_e( 'Location' , 'woocommerce-bookings' );?></h4>
              <?php the_field('location'); ?>
            </div>
            <?php endif; ?>
            <?php if ($product->get_duration()) : ?>
            <div class="detail-item">
              <h4><?php esc_html_e( 'Duration' , 'woocommerce-bookings' );?></h4>
              <?php echo $product->get_duration(); echo str_repeat( '&nbsp;', 1 ) . __( 'hours', 'woocommerce-bookings' ); ?>
            </div>
            <?php endif; ?>
            <?php if ($schedule) : ?>
            <div class="detail-item">
              <h4><?php esc_html_e( 'Times' , 'woocommerce-bookings' );?></h4>
              <?php
                foreach ($schedule as $day) {
                  if ($day['times'] != []) {
                    ?>
                    <span>
                      <?php
                      echo $day['name'] . $separator;
                      foreach ($day['times'] as $i => $time) {
                        echo $time;
                        if ($i != count($day['times']) - 1)
                          echo __( ',' , 'punctuation' ) . str_repeat( '&nbsp;', 1 );
                      }
                      ?>
                    </span><br>
                  <?php
                  }
                }
              ?>
            </div>
            <?php endif; ?>
            <div class="detail-item">
              <h4><?php esc_html_e( 'Group size' , 'woocommerce-bookings' );?></h4>
              <?php echo $product->get_min_persons() . __( '~', 'punctuation' ) . $product->get_max_persons() . str_repeat( '&nbsp;', 1 ) . __( 'people', 'woocommerce-bookings' ); ?>
            </div>
            <?php if ( get_field('included') ) : ?>
            <div class="detail-item">
              <h4><?php esc_html_e( 'Included' , 'woocommerce-bookings' );?></h4>
              <?php the_field('included'); ?>
            </div>
            <?php endif; ?>
            <?php if ( get_field('not_included') ) : ?>
            <div class="detail-item">
              <h4><?php esc_html_e( 'Not included' , 'woocommerce-bookings' );?></h4>
              <?php the_field('not_included'); ?>
            </div>
            <?php endif; ?>
          </div>
          <div id="tour-overview" class="tour-content toggle">
            <?php the_field('overview'); ?>
          </div>
        </div>
      </div>
    </div>

    <?php

    else :

    ?><pre><?php _e( 'Cannot load product content. Please activate ACF and / or WooCommerce Bookings', 'woocommerce-bookings' ) ?></pre><?php

    endif;
  }

  /**
   * Product main content
   * @return string
   */
  public function create_product_main_content() {
    ?>
    <div class="product-main-wrapper">
      <?php do_action('product_main_content'); ?>
    </div>
    <div class="summary-wrapper"><div class="summary-wrapper-inner">
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

endif;
