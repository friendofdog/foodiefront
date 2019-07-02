<?php

/**
 * Foodie Japan Contact Form 7
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Foodie_Japan_Contact' ) ) :

class Foodie_Japan_Contact {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    add_action( 'shortcode_atts_wpcf7', array( $this, 'fj_custom_shortcode_atts_wpcf7_filter' ) );
  }

  /**
   * CF7 shortcode
   * @return add shortcode for default title
   */
  public function fj_custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
      $tour_title = 'tour-title';

      if ( isset( $atts[$tour_title] ) ) {
          $out[$tour_title] = $atts[$tour_title];
      }

      return $out;
  }
}

endif;

return new Foodie_Japan_Contact();
