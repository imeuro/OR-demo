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
		<div class="site-info">
			&copy; 2022 <a href="https://openregister.io">openregister.io</a> - all rights reserved
			<!-- <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'or-demo' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress.
				printf( esc_html__( 'Proudly powered by %s', 'or-demo' ), 'WordPress' ); */
				?>
			</a>
			<span class="sep"> | </span> -->
				<?php
				/* translators: 1: Theme name, 2: Theme author.
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'or-demo' ), 'or-demo', '<a href="https://meuro.dev">Mauro Fioravanzi</a>' ); */
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
