<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package or-demo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&family=Archivo:wght@400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/or-demo.css" media="all">
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'or-demo' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$or_demo_description = get_bloginfo( 'description', 'display' );
			if ( $or_demo_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $or_demo_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			  <div class="hambmenu">
			    <div class="bar"></div>
			    <div class="bar"></div>
			    <div class="bar"> </div>
			  </div>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
		
		<?php 
		// print_r(get_uploaded_header_images());
		if (is_home() || is_front_page()) {

			if (in_array('ml-slider/ml-slider.php', apply_filters('active_plugins', get_option('active_plugins')))) : 
				echo do_shortcode('[metaslider title="site header"]');
			elseif (post_type_exists('header_images')) : 

				$args = array(
					'post_type'				=> array( 'header_images'),
					'post_status'			=> array( 'publish' ),
					'posts_per_page' 		=> 1, 
					'order'					=> 'ASC',
				);

				$carousel = new WP_Query( $args ); 
				    
				while ( $carousel->have_posts() ) : $carousel->the_post(); 
				    the_content(); 
				endwhile;

				wp_reset_postdata(); 
			else :
				the_custom_header_markup(); 
			endif; 
		} ?>
	</header><!-- #masthead -->
