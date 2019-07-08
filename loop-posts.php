<?php

do_action( 'storefront_loop_before' );

$count = 0;
$index = 0;
if( have_posts() ) :
  echo '<div class="posts-grid posts-row-' . $index . '">';
    while ( have_posts() ) : the_post();
    if ($count < 3) {
      get_template_part( 'content-post-loop', get_post_format() );
    } else {
      $index = $index + 1;
      echo '</div><div class="posts-grid posts-row-' . $index . '">';
    	get_template_part( 'content-post-loop', get_post_format() );
      $count = 0;
    }
    $count = $count + 1;
    endwhile; ?>
  </div>
<?php endif;

do_action( 'storefront_loop_after' );
