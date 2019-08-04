<?php
/**
 * Post loop for tours
 * storefront_2.5.0
 *
 * @package storefront
 * @since   1.0
 */

do_action( 'storefront_loop_before' );

if( have_posts() ) :
  echo '<div class="polaroid-grid">';
    while ( have_posts() ) : the_post();
      get_template_part( 'content-polaroid-loop', get_post_format() );
    endwhile; ?>
  </div>
<?php endif;

do_action( 'storefront_loop_after' );
