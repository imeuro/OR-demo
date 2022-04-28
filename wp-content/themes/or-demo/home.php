<?php get_header(); ?>

<main id="primary" class="site-main site-home">
	<?php
	$args = array(
		'post_type'				=> array( 'page' ),
		'post_status'			=> array( 'publish' ),
		'post__not_in' 			=> array(3,24), // no privacy, no contacts
		'order'					=> 'ASC',
		'orderby'				=> 'menu_order',
	);
	$homepost = new WP_Query( $args );
	if ( $homepost->have_posts() ) {
		while ( $homepost->have_posts() ) {
			$homepost->the_post();
			// do something
			echo '<article class="post-'.$homepost->id.' page type-page status-publish hentry">';
			echo '<a id="#'.$homepost->post_name.'"><h2 class="page-title">'.get_the_title().'</h2></a>';
			the_content();
			echo '</article>';
		}
	} else {
		// no posts found
	}

	// Restore original Post Data
	wp_reset_postdata();
	?>
</main>

<?php get_footer(); ?>