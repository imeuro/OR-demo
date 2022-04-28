<?php
/**
 * @package OR-demo
 * @version 0.0.2
 */
/*
Plugin Name: OR-demo
Plugin URI: http://openregister.io/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire team summed up in one word.
Author: Mauro Fioravanzi
Version: 0.0.2
Author URI: http://meuro.dev/
*/




if ( ! function_exists('header_images') ) {

// Register Custom Post Type
function header_images() {

	$labels = array(
		'name'                  => _x( 'Header images', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Header image', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Header images', 'text_domain' ),
		'name_admin_bar'        => __( 'Header images', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Header image', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_rest' => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-format-gallery',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'header_images', $args );

}
add_action( 'init', 'header_images', 0 );


function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">Discover more</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );
}