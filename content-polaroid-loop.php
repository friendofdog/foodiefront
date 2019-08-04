<?php
/**
 * Wrapper for tour posts loop
 * storefront_2.5.0
 *
 * @package storefront
 * @since   1.0
 */

?>

<div class="polaroid-panel-wrapper">
  <a href="<?php echo get_post_permalink(); ?>" class="polaroid-panel">
    <?php echo get_the_post_thumbnail( $post, 'woocommerce_thumbnail' ); ?>
    <div class="text-wrapper">
      <h4 class="text-title"><?php the_title(); ?></h4>
    </div>
  </a>
</div>
