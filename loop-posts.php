<?php

do_action( 'storefront_loop_before' );

if( have_posts() ) :
  echo '<div class="posts-grid">';
    while ( have_posts() ) : the_post();
      get_template_part( 'content-post-loop', get_post_format() );
    endwhile; ?>
  </div>
<?php endif;

do_action( 'storefront_loop_after' );
