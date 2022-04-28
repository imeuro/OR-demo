<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package or-demo
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-contacts">
			<?php
			$contacts = new WP_Query( 'page_id=24' ); // contacts page
			if ( $contacts->have_posts() ) {
				while ( $contacts->have_posts() ) {
					$contacts->the_post();
					the_content();
					//print_r($contacts);
				}
			}
			wp_reset_postdata();
			?>
		</div>
	</footer><!-- #colophon -->
	<div class="site-info">
		&copy; 2022 <a href="https://openregister.io">openregister.io</a> - all rights reserved
	</div><!-- .site-info -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
