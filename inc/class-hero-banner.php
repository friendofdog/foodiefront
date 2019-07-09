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
    add_action( 'wp_enqueue_scripts', array( $this, 'hero_header_banner_background' ), 160 );
    add_action( 'storefront_before_content', array( $this, 'hero_header_banner_init' ) );
  }

  /**
   * Hero header banner inline style
   * @return void
   */
  public function hero_header_banner_background() {
    $image = get_field('background_image');

    if ( $image ) :

    $image_src = $image['sizes']['hero-banner'];

    wp_register_style( 'hero-banner-style', false );
    wp_enqueue_style( 'hero-banner-style' );
    wp_add_inline_style( 'hero-banner-style', '
      .hero-banner {
        background-image: url(' . $image_src . ');
      }
    ' );

    endif;
  }

  /**
   * Hero header banner
   * @return void
   */
  public function hero_header_banner_init() {
    $is_active = get_field('is_active');
    $header = get_field('header');
    $text = get_field('text');
    $image_src = get_field('background_image')['sizes']['hero-banner'];
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
