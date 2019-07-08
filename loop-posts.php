<?php

do_action( 'storefront_loop_before' );

$count = 0;
if( have_posts() ) : ?>
  <div class="posts-grid">
    <?php while ( have_posts() ) : the_post();
    if ($count < 3) {
      get_template_part( 'content-post-loop', get_post_format() );
    } else {
      echo '</div><div class="posts-grid">';
    	get_template_part( 'content-post-loop', get_post_format() );
      $count = 0;
    }
    $count = $count + 1;
    endwhile; ?>
  </div>
<?php endif;

do_action( 'storefront_loop_after' );
