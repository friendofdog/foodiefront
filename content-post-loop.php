<div class="post-panel-wrapper">
  <a href="<?php echo get_post_permalink(); ?>" class="post-panel">
    <?php echo get_the_post_thumbnail( $post, 'woocommerce_thumbnail' ); ?>
    <div class="text-wrapper">
      <h4 class="text-title"><?php the_title(); ?></h4>
    </div>
  </a>
</div>
