<?php
/**
 * Plugin Name:       Advanced Animation
 * Description:       Advanced animation for gutenberg block.
 * Requires at least: 5.0
 * Requires PHP:      5.6
 * Version:           1.2.2
 * Author:            Advanced Animation
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       advanced-animation
 * Domain Path: /languages
 *
 */

define( "ADVANCED_ANIMATION_VERSION", "1.2.2" );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/
 */
function create_block_advanced_animation_block_init() {
	register_block_type( __DIR__ );
}
add_action( 'init', 'create_block_advanced_animation_block_init' );


function advanced_animation_load_textdomain() {
	load_plugin_textdomain(
		'advanced-animation',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
	);
	wp_set_script_translations( 'advanced-animation-script', 'advanced-animation' );
}
add_action( 'init', 'advanced_animation_load_textdomain' ); 

// register custom meta tag field
function advanced_animation_post_meta() {
	register_post_meta( 'post', '_advanced_animation_props', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
			}
	) );
	register_post_meta( 'page', '_advanced_animation_props', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
			}
	) );

	register_post_meta( 'post', '_moveable', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
			}
	) );
	register_post_meta( 'page', '_moveable', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
			}
	) );
}
add_action( 'init', 'advanced_animation_post_meta' );

function advanced_animation_script() {
	global $post, $animation_meta;
		$post_id = $post->ID;
		$animation = get_post_meta($post_id, "_advanced_animation_props", true);
		$animation_meta = json_decode($animation);
		$moveable = get_post_meta($post_id, "_moveable", true);
	
		wp_enqueue_script('frontend-script', plugin_dir_url(__FILE__) . 'build/frontend.js',  array(), ADVANCED_ANIMATION_VERSION, true);
		wp_localize_script('frontend-script', 'animationGlobal', array("props" => $animation));
		$inline_css = "";
		if(!empty($moveable)){
			$decode = json_decode($moveable);
			foreach($decode as $id=>$properties){
				if($id && $properties && $id != "undefined" && !empty($properties)){
					$inline_css .= ".position-$id{";
					foreach($properties as $key => $value){
						$inline_css .= "$key:$value; ";
					}
					$inline_css .= "}";					
				}
			}
		}
		wp_enqueue_style('frontend-style', plugin_dir_url(__FILE__) . 'build/style-index.css',  array(), ADVANCED_ANIMATION_VERSION, "all");
		wp_add_inline_style( 'frontend-style', $inline_css );
	
}

add_action( 'wp_enqueue_scripts', 'advanced_animation_script' );

function advanced_animation_render_block($block_content, $block){
	
	global $animation_meta;	
	$attrs = $block['attrs'];

	$class = "";
	$style = "";
	if(isset($attrs["classAnimation"]) && count($attrs["classAnimation"]) && !empty($attrs["animationId"])){
		$class = empty($class) ? "animation-". $attrs["animationId"] : $class ." animation-". $attrs["animationId"];
		if(isset($animation_meta->settings) && isset($animation_meta->settings->{$attrs["animationId"]})){
			$settings = $animation_meta->settings->{$attrs["animationId"]};
			foreach($settings as $key => $value){
				if(isset($value->triggerType) && $value->triggerType === "onVisible" && isset($animation_meta->animations->{$key})){
					$init_styles = $animation_meta->animations->{$key}->keyframes->{"0%"};
					if(!empty($init_styles)){

						$style="<style> .animation-".$attrs['animationId']."{";
						foreach($init_styles as $css_property => $css_value){
							if($css_property === "transform"){
								$style .= "transform:";
								foreach($init_styles->transform as $transform_property => $transform_value){
									$style .= "$transform_property($transform_value)";
								}
								$style .= ";";
							}else{
								$style .= "$css_property:$css_value;";
							}
						}

						$style.="}</style>";
					}
				}
			}
		}

	}

	if(isset($attrs["parallax"]) && !empty($attrs["parallax"]["enable"])){
		$class = empty($class) ? "block-rellax" : $class ." block-rellax";		

		$data = "";
		if(isset($attrs["parallax"])){
			if(isset($attrs["parallax"]["speed"]) && $attrs["parallax"]["speed"] !== -2){
				$speed = $attrs["parallax"]["speed"];
				$data .= "data-rellax-speed='$speed' "; 
			}

			if(isset($attrs["parallax"]["zindex"]) && $attrs["parallax"]["zindex"] !== -2){
				$zindex = $attrs["parallax"]["zindex"];
				$data .= "data-rellax-zindex='$zindex' "; 
			}

			if($data !== "" && is_string($block_content)){
				$data .= "class";
				$pos = strpos($block_content, "class");
				if ($pos !== false) {
					$block_output = substr_replace($block_content, $data, $pos, 5);
					return $block_output;
				}
			}
		}
	}

	if(isset($attrs["moveable"]) && (!empty($attrs["moveable"]["transform"]) || !empty($attrs["moveable"]["style"]) || !empty($attrs["moveable"]["css"])) && isset($attrs["moveable"]["id"]) ){
		$class = empty($class) ? "position-". $attrs["moveable"]["id"] : $class ." position-". $attrs["moveable"]["id"];
	}

	if(isset($attrs["galleryAnimation"]) && isset($attrs["galleryAnimationEffect"])){
		$gallery_class = "gallery-animation gallery-animation-" .$attrs["galleryAnimationEffect"];
		$class = empty($class) ? $gallery_class : $class ." " .$gallery_class;	
	}

	if(!empty($class)){
		$pos = strpos($block_content, $class);
		$class = 'class="'. $class . " ";
		if($pos === false){
			$pos = strpos($block_content, "class");
			if ($pos !== false) {
				$block_content = substr_replace($block_content, $class, $pos, 7);
			}
		}
	}
	
	return $style .$block_content;
}

add_filter( 'render_block', 'advanced_animation_render_block', 10, 2);
