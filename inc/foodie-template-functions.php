<?php

/**
 * Header open
 * storefront_2.5.0
 *
 * @since 1.0.0
 */
function storefront_header_container() {
  echo '<div><div class="preheader">';
}

/**
 * Header close
 * storefront_2.5.0
 *
 * @since 1.0.0
 */
function storefront_header_container_close() {
  echo '</div>';
}

/**
 * Nav open
 * storefront_2.5.0
 *
 * @since 1.0.0
 */
function storefront_primary_navigation_wrapper() {
  echo '<div class="storefront-primary-navigation">';
}

/**
 * Nav close
 * storefront_2.5.0
 *
 * @since 1.0.0
 */
function storefront_primary_navigation_wrapper_close() {
  echo '</div></div>';
}

/**
 * Posts header
 * storefront_2.5.0
 *
 * @since 1.0.0
 */
function storefront_post_header() {
  ?>
  <header class="entry-header">
  <?php

  do_action( 'storefront_post_header_before' );

  if ( is_single() ) {
    the_title( '<h1 class="entry-title">', '</h1>' );
  } else {
    if ( get_post_type() === 'press' && class_exists( 'ACF' ) && get_field( 'link' ) ) {
      the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" target="_blank" rel="bookmark">', esc_url( get_field( 'link' ) ) ), '</a></h2>' );
    } else {
      the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    }
    do_action( 'foodiefront_post_header_title_after' );
  }

  do_action( 'storefront_post_header_after' );
  ?>
  </header><!-- .entry-header -->
  <?php
}

/**
 * Display the post meta
 * storefront_2.5.0
 *
 * @since 1.0.0
 */
function storefront_post_meta() {
	if ( !in_array( get_post_type(), ['post', 'press']) ) {
		return;
	}

	// Posted on.
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

	$posted_on = '
		<span class="posted-on">' .
		/* translators: %s: post date */
		sprintf( __( 'Posted on %s', 'storefront' ), $output_time_string ) .
		'</span>';

	// Author.
	$author = sprintf(
		'<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
		__( 'by', 'storefront' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	// Comments.
	$comments = '';

	if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
		$comments_number = get_comments_number_text( __( 'Leave a comment', 'storefront' ), __( '1 Comment', 'storefront' ), __( '% Comments', 'storefront' ) );

		$comments = sprintf(
			'<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
			esc_url( get_comments_link() ),
			$comments_number
		);
	}

	echo wp_kses(
		sprintf( '%1$s %2$s %3$s', $posted_on, $author, $comments ), array(
			'span' => array(
				'class' => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		)
	);
}
