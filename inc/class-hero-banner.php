<?php

/**
 * Foodie Japan Hero Banner
 *
 * @author   FriendOfDog
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'Foodie_Japan_Hero_Banner' ) ) :

class Foodie_Japan_Hero_Banner {
  /**
   * Setup class.
   *
   * @since 1.0
   */
  public function __construct() {
    if ( class_exists( 'ACF' ) && function_exists( 'aq_resize' ) ) {
      add_action( 'wp_enqueue_scripts', array( $this, 'hero_header_banner_background' ), 160 );
      add_action( 'acf/init', array( $this, 'create_hero_banner_acf_fields' ) );
      add_action( 'storefront_before_content', array( $this, 'hero_header_banner_init' ) );
    }
  }

  /**
   * Create ACF fields for hero banner
   * @return null
   */
  public function create_hero_banner_acf_fields() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
    	'key' => 'hero_banner',
    	'title' => 'Hero banner',
    	'fields' => array (
    		array (
    			'key' => 'is_active',
    			'label' => 'Is active',
    			'name' => 'is_active',
    			'type' => 'true_false'
    		),
        array (
          'key' => 'text',
          'label' => 'Text',
          'name' => 'text',
          'type' => 'wysiwyg',
          'tabs' => 'text',
          'toolbar' => 'basic',
          'media_upload' => 0
        ),
        array (
          'key' => 'background_image',
          'label' => 'Background image',
          'name' => 'background_image',
          'type' => 'image'
        ),
        array (
          'key' => 'header',
          'label' => 'Header',
          'name' => 'header',
          'type' => 'text'
        )
    	),
    	'location' => array (
    		array (
    			array (
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'page',
    			),
    		),
    	),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label'
    ));

    acf_add_local_field( array(
      'key'               => 'buttons',
      'label'             => 'Buttons',
      'name'              => 'buttons',
      'type'              => 'repeater',
      'parent'            => 'hero_banner',
      'max'               => 2,
      'layout'            => 'table',
      'button_label'      => 'Add new button'
    ));

    acf_add_local_field( array(
      'key'            => 'button_text',
      'label'          => 'Button text',
      'name'           => 'button_text',
      'parent'         => 'buttons',
      'type'           => 'text'
    ));

    acf_add_local_field( array(
      'key'            => 'button_link',
      'label'          => 'Button link',
      'name'           => 'button_link',
      'parent'         => 'buttons',
      'type'           => 'text'
    ));

    endif;
  }


  /**
   * Hero header banner inline style
   * @return string
   */
  public function hero_header_banner_background() {
    $image = get_field('background_image');

    if ( $image ) :

      $img_url = wp_get_attachment_url( $image['id'], 'full' );
      $resize_mobile = aq_resize( $img_url, 800, 600, true );
      $resize_desktop = aq_resize( $img_url, 1800, 600, true );
      $img_mobile = $resize_mobile ? $resize_mobile : $img_url;
      $img_desktop = $resize_desktop ? $resize_desktop : $img_url;

      wp_register_style( 'hero-banner-style', false );
      wp_enqueue_style( 'hero-banner-style' );
      wp_add_inline_style( 'hero-banner-style', '
        .hero-banner {
          background-image: url(' . $img_mobile . ');
        }

        @media (min-width: 768px) {
          .hero-banner {
            background-image: url(' . $img_desktop . ');
          }
        }
      ' );

    endif;
  }

  /**
   * Hero header banner
   * @return string
   */
  public function hero_header_banner_init() {
    $is_active = get_field('is_active');
    $header = get_field('header');
    $text = get_field('text');
    $buttons = get_field('buttons');

    if ( $is_active ) : ?>

      <div class="hero-banner-wrapper">
        <div class="hero-banner">
          <div>
            <h1><?php the_field('header'); ?></h1>
            <div class="banner-text"><?php the_field('text'); ?></div>
            <?php if ($buttons) : ?>
            <div class="button-wrapper">
              <?php foreach ($buttons as $button) { ?>
              <a class="button primary-button" href="<?php echo $button->button_link; ?>">
                <?php echo $button['button_text']; ?>
              </a>
              <?php } ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

    <?php endif;
  }
}

endif;

return new Foodie_Japan_Hero_Banner();
