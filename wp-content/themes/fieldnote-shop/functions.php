<?php
/**
 * Fieldnote Shop — theme bootstrap.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

define( 'FNS_VERSION', '1.0.0' );

/**
 * Theme supports, menus, image sizes.
 */
function fns_setup() {
	load_theme_textdomain( 'fieldnote-shop', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'fieldnote-shop' ),
			'footer'  => __( 'Footer menu', 'fieldnote-shop' ),
		)
	);

	add_image_size( 'fns-card', 640, 640, true );
	add_image_size( 'fns-hero', 1200, 900, true );
}
add_action( 'after_setup_theme', 'fns_setup' );

/**
 * Front-end assets. Versioned by file modification time for cache busting.
 */
function fns_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'fns-main', $uri . '/assets/css/main.css', array(), filemtime( $dir . '/assets/css/main.css' ) );

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'fns-woo', $uri . '/assets/css/woocommerce.css', array( 'fns-main' ), filemtime( $dir . '/assets/css/woocommerce.css' ) );
	}

	wp_enqueue_script(
		'fns-main',
		$uri . '/assets/js/main.js',
		array(),
		filemtime( $dir . '/assets/js/main.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fns_assets', 20 );

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/accessibility.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/woocommerce.php';
