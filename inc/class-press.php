<?php

/**
 * Foodie Japan
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Foodie_Japan_Press' ) ) :

class Foodie_Japan_Press {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    add_filter( 'the_content_more_link', array( $this, 'redirect_read_more_link' ) );
    add_filter( 'get_the_archive_title', array( $this, 'press_remove_archive_title' ) );

    add_action( 'init', array( $this, 'press_custom_post_type_init' ) );
    add_action( 'acf/init', array( $this, 'create_press_acf_fields' ) );
    add_action( 'template_redirect', array( $this, 'press_redirect_to_external' ) );
    add_action( 'foodiefront_post_header_title_after', array( $this, 'press_custom_post_meta' ), 10 );
  }

  /**
   * Replace read more destination
   * @return object
   */
  public function redirect_read_more_link( $link ) {
    if ( get_post_type() === 'press' && class_exists( 'ACF' ) ) {
      if ( get_field( 'link' ) ) {
        $link = preg_replace('/href="(http:\/\/[^\/"]+\/?)?([^"]*)"/', "href=\"" . get_field( 'link' ) . "\" target=\"_blank\"", $link);
      }
    }
    return $link;
  }

  /**
   * Remove archive title
   * @return object
   */
  public function press_remove_archive_title( $title ) {
    if( get_post_type() === 'press' ) {
      $title = explode( ': ', $title, 2 )[1];
    }
    return $title;
  }

  /**
   * Press custom post types
   * @return void
   */
  public function press_custom_post_type_init() {
    $args = array(
      'public'                => true,
      // 'taxonomies'            => array( 'category' ),
      'label'                 => 'Press',
      'position'              => '20.4',
      'exclude_from_search'   => false,
      'menu_icon'             => 'dashicons-megaphone',
      'has_archive'           => true,
      // 'publicly_queryable'    => false,
      'supports'              => array('page-attributes', 'editor', 'title'),
    );
    register_post_type( 'press', $args );
  }

  /**
   * Create ACF fields for press posts
   * @return null
   */
  public function create_press_acf_fields() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
    	'key' => 'press',
    	'title' => 'Press',
    	'fields' => array (
        array (
          'key' => 'source',
          'label' => 'Source',
          'name' => 'source',
          'type' => 'text'
        ),
        array (
          'key' => 'link',
          'label' => 'Link',
          'name' => 'link',
          'type' => 'url'
        )
    	),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'press',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label'

    ));

    endif;
  }

  /**
   * Press redirect to external site
   * @return void
   */
  public function press_redirect_to_external() {
    if ( is_singular( 'press' ) && class_exists( 'ACF' ) ) {
      if ( get_field( 'link' ) ) {
        wp_redirect( get_field( 'link' ), 302 );
        exit;
      }
    }
  }

  /**
   * Press custom post types
   * @return string
   */
  public function press_custom_post_meta() {
    if ( get_post_type() === 'press' && class_exists( 'ACF' ) ) {
      if ( get_field( 'source' ) ) {
        echo '<p>';
        echo __( 'Source', 'foodie-japan' ) . __( ':' , 'punctuation' ) . str_repeat( '&nbsp;', 1 );
        the_field( 'source' );
        echo '</p>';
      }
    }
  }
}

endif;

return new Foodie_Japan_Press();
