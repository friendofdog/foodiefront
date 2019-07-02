<?php

/**
 * Foodie Japan Yoast
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Foodie_Japan_Yoast' ) ) :

class Foodie_Japan_Yoast {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    add_action( 'manage_edit-product_columns', array( $this, 'fj_yoast_admin_remove_columns' ) );
  }

  /**
   * Unset fields
   * @return remove unneded yoast fields
   */
  public function fj_yoast_admin_remove_columns( $columns ) {
    unset($columns['wpseo-score']);
    unset($columns['wpseo-score-readability']);
    unset($columns['wpseo-title']);
    unset($columns['wpseo-metadesc']);
    unset($columns['wpseo-focuskw']);
    unset($columns['wpseo-links']);
    unset($columns['wpseo-linked']);
    return $columns;
  }
}

endif;

return new Foodie_Japan_Yoast();
