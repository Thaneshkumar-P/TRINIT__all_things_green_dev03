<?php
/**
	*
	* @author     Gaviasthemes Team     
	* @copyright  Copyright (C) 2022 Gaviasthemes. All Rights Reserved.
	* @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
	* 
*/

define('ORGARIUM_THEME_DIR', get_template_directory());
define('ORGARIUM_THEME_URL', get_template_directory_uri());

// Include list of files of theme.
require_once(ORGARIUM_THEME_DIR . '/includes/functions.php'); 
require_once(ORGARIUM_THEME_DIR . '/includes/template.php'); 
require_once(ORGARIUM_THEME_DIR . '/includes/hook.php'); 
require_once(ORGARIUM_THEME_DIR . '/includes/comment.php'); 
require_once(ORGARIUM_THEME_DIR . '/includes/metaboxes.php');
require_once(ORGARIUM_THEME_DIR . '/includes/customize.php'); 
require_once(ORGARIUM_THEME_DIR . '/includes/menu.php'); 
require_once(ORGARIUM_THEME_DIR . '/includes/elementor/hooks.php');

//Load Woocommerce plugin
if(class_exists('WooCommerce')){
	add_theme_support('woocommerce');
	require_once(ORGARIUM_THEME_DIR . '/includes/woocommerce/functions.php'); 
	require_once(ORGARIUM_THEME_DIR . '/includes/woocommerce/hooks.php'); 
}


// Load Redux - Theme options framework
if(class_exists('Redux')){
	require(ORGARIUM_THEME_DIR . '/includes/options/init.php');
	require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-general.php'); 
	require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-header.php'); 
	require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-footer.php'); 
	require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-styling.php'); 
	require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-page.php'); 
	require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-portfolio.php'); 
	if(class_exists('WooCommerce')){
		require_once(ORGARIUM_THEME_DIR . '/includes/options/opts-woo.php'); 
	}
}

// TGM plugin activation
if (is_admin()) {
	require_once(ORGARIUM_THEME_DIR . '/includes/tgmpa/class-tgm-plugin-activation.php');
	require(ORGARIUM_THEME_DIR . '/includes/tgmpa/config.php');
}
load_theme_textdomain('orgarium', get_template_directory() . '/languages');

//-------- Register sidebar default in theme -----------
//------------------------------------------------------
function orgarium_widgets_init() {
	register_sidebar(array(
		'name' 				=> esc_html__('Default Sidebar', 'orgarium'),
		'id' 					=> 'default_sidebar',
		'description' 		=> esc_html__('Appears in the Default Sidebar section of the site.', 'orgarium'),
		'before_widget' 	=> '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h3 class="widget-title"><span>',
		'after_title' 		=> '</span></h3>',
	));

	if(class_exists('WooCommerce')){
		register_sidebar( array(
			'name' 				=> esc_html__('WooCommerce Shop Sidebar', 'orgarium'),
			'id' 					=> 'woocommerce_sidebar',
			'description' 		=> esc_html__('Appears in the Plugin WooCommerce section of the site.', 'orgarium'),
			'before_widget' 	=> '<aside id="%1$s" class="widget clearfix %2$s">',
			'after_widget'	 	=> '</aside>',
			'before_title' 	=> '<h3 class="widget-title"><span>',
			'after_title' 		=> '</span></h3>',
		));
	}
	register_sidebar(array(
		'name' 				=> esc_html__('After Offcanvas Mobile', 'orgarium'),
		'id' 					=> 'offcanvas_sidebar_mobile',
		'description' 		=> esc_html__('Appears in the Offcanvas section of the site.', 'orgarium'),
		'before_widget' 	=> '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h3 class="widget-title"><span>',
		'after_title' 		=> '</span></h3>',
	));
	
}
add_action('widgets_init', 'orgarium_widgets_init');


function orgarium_fonts_url() { 
	$fonts_url = '';
	$fonts     = array();
	$subsets   = '';
	$protocol = is_ssl() ? 'https' : 'http';
	if('off' !== _x('on', 'Manrope font: on or off', 'orgarium')){
		$fonts[] = 'Manrope:wght@400;500;600;700;800';
	}
	if('off' !== _x('on', 'Handlee font: on or off', 'orgarium')){
		$fonts[] = 'Handlee';
	}
	if($fonts){
		$fonts_url = add_query_arg( array(
			'family' => (implode('&family=', $fonts)),
			'display' => 'swap',
		),  $protocol.'://fonts.googleapis.com/css2');
	}
	return $fonts_url;
}

function orgarium_custom_styles() {
	$custom_css = get_option('orgarium_theme_custom_styles');
	if($custom_css){
		wp_enqueue_style(
			'orgarium-custom-style',
			ORGARIUM_THEME_URL . '/assets/css/custom_script.css'
		);
		wp_add_inline_style('orgarium-custom-style', $custom_css);
	}
}
add_action('wp_enqueue_scripts', 'orgarium_custom_styles', 9999);

function orgarium_init_scripts(){
	global $post;
	$protocol = is_ssl() ? 'https' : 'http';
	if ( is_singular() && comments_open() && get_option('thread_comments') ){
		wp_enqueue_script('comment-reply');
	}

	$theme = wp_get_theme('orgarium');
	$theme_version = $theme['Version'];

	wp_enqueue_style('orgarium-fonts', orgarium_fonts_url(), array(), null );
	
	wp_enqueue_script('bootstrap', ORGARIUM_THEME_URL . '/assets/js/bootstrap.min.js', array('jquery') );
	wp_enqueue_script('jquery-magnific-popup', ORGARIUM_THEME_URL . '/assets/js/magnific/jquery.magnific-popup.min.js');
	wp_enqueue_script('jquery-cookie', ORGARIUM_THEME_URL . '/assets/js/jquery.cookie.js', array('jquery'));
	wp_enqueue_script('swiper', ORGARIUM_THEME_URL . '/assets/js/swiper/swiper.min.js');
	wp_enqueue_script('jquery-appear', ORGARIUM_THEME_URL . '/assets/js/jquery.appear.js');
	wp_enqueue_script('orgarium-main', ORGARIUM_THEME_URL . '/assets/js/main.js', array('imagesloaded', 'jquery-masonry'));
  
	wp_enqueue_style('dashicons');
	wp_enqueue_style('swiper', ORGARIUM_THEME_URL .'/assets/js/swiper/swiper.min.css');
	wp_enqueue_style('magnific', ORGARIUM_THEME_URL .'/assets/js/magnific/magnific-popup.css');
	wp_enqueue_style('fontawesome', ORGARIUM_THEME_URL . '/assets/css/fontawesome/css/all.min.css');
	wp_enqueue_style('line-awesome', ORGARIUM_THEME_URL . '/assets/css/line-awesome/css/line-awesome.min.css');

	wp_enqueue_style('orgarium-style', ORGARIUM_THEME_URL . '/style.css');
	wp_enqueue_style('bootstrap', ORGARIUM_THEME_URL . '/assets/css/bootstrap.css', array(), $theme_version , 'all'); 
	wp_enqueue_style('orgarium-template', ORGARIUM_THEME_URL . '/assets/css/template.css', array(), $theme_version , 'all');
	
	//Woocommerce
	if(class_exists('WooCommerce')){
		wp_enqueue_style('orgarium-woocoomerce', ORGARIUM_THEME_URL . '/assets/css/woocommerce.css', array(), $theme_version , 'all'); 
		wp_dequeue_script('wc-add-to-cart');
		wp_enqueue_script('wc-add-to-cart', ORGARIUM_THEME_URL . '/assets/js/add-to-cart.js' , array('jquery'));
	}
} 
add_action('wp_enqueue_scripts', 'orgarium_init_scripts', 999);
