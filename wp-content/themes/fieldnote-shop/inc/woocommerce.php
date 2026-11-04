<?php
/**
 * WooCommerce integration.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

function fns_woo_setup() {
	add_theme_support( 'woocommerce', array( 'thumbnail_image_width' => 640, 'single_image_width' => 900 ) );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'fns_woo_setup' );

// Use our own <main> wrapper (see woocommerce.php) instead of Woo's divs and sidebar.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'loop_shop_per_page', function () { return 12; } );

/** Breadcrumb as a labelled navigation landmark. */
add_filter( 'woocommerce_breadcrumb_defaults', function ( $defaults ) {
	$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'fieldnote-shop' ) . '"><ol class="breadcrumb-list">';
	$defaults['wrap_after']  = '</ol></nav>';
	$defaults['before']      = '<li>';
	$defaults['after']       = '</li>';
	$defaults['delimiter']   = '';
	return $defaults;
} );

/** Badge from the ACF "Badge" field, shown as text (never colour alone). */
function fns_product_badge() {
	$badge  = fns_field( 'product_badge' );
	$labels = array(
		'new'     => __( 'New', 'fieldnote-shop' ),
		'limited' => __( 'Limited run', 'fieldnote-shop' ),
		'restock' => __( 'Back in stock', 'fieldnote-shop' ),
	);
	if ( isset( $labels[ $badge ] ) ) {
		printf( '<span class="badge badge--%1$s">%2$s</span>', esc_attr( $badge ), esc_html( $labels[ $badge ] ) );
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'fns_product_badge', 5 );
add_action( 'woocommerce_single_product_summary', 'fns_product_badge', 1 );

/** Spec list on the single product page, built from ACF fields. */
function fns_product_specs() {
	$rows = array(
		__( 'Materials', 'fieldnote-shop' )  => fns_field( 'product_material' ),
		__( 'Dimensions', 'fieldnote-shop' ) => fns_field( 'product_dimensions' ),
	);
	if ( fns_field( 'product_eco' ) ) {
		$rows[ __( 'Sustainability', 'fieldnote-shop' ) ] = __( 'Made with recycled materials', 'fieldnote-shop' );
	}
	$rows = array_filter( $rows );
	if ( ! $rows ) {
		return;
	}
	echo '<dl class="spec-list">';
	foreach ( $rows as $label => $value ) {
		printf( '<div><dt>%s</dt><dd>%s</dd></div>', esc_html( $label ), esc_html( $value ) );
	}
	echo '</dl>';
}
add_action( 'woocommerce_single_product_summary', 'fns_product_specs', 25 );

/** "Care" tab, only when the ACF field is filled in. */
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	if ( fns_field( 'product_care' ) ) {
		$tabs['care'] = array(
			'title'    => __( 'Care', 'fieldnote-shop' ),
			'priority' => 30,
			'callback' => function () {
				echo '<h2>' . esc_html__( 'Care', 'fieldnote-shop' ) . '</h2>';
				echo wp_kses_post( wpautop( fns_field( 'product_care' ) ) );
			},
		);
	}
	return $tabs;
} );

/** Live-update the header cart count via Woo's cart fragments. */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$fragments['span.cart-count'] = '<span class="cart-count" data-cart-count>' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span>';
	return $fragments;
} );
