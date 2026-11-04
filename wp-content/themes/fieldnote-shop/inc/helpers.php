<?php
/**
 * Small helpers shared by templates.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Read a custom field. Uses ACF when active, otherwise falls back to plain post meta,
 * so the theme never fatals if the plugin is deactivated.
 *
 * @param string   $name    Field name.
 * @param int|bool $post_id Post ID (false = current post).
 * @param mixed    $default Returned when the field is empty.
 * @return mixed
 */
function fns_field( $name, $post_id = false, $default = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$value   = null;

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
	}
	if ( null === $value || '' === $value || false === $value ) {
		$value = get_post_meta( $post_id, $name, true );
	}

	return ( null === $value || '' === $value || false === $value ) ? $default : $value;
}

/**
 * Fallback menu: shown only until an editor assigns a menu.
 */
function fns_menu_fallback() {
	echo '<ul id="primary-menu" class="menu"><li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'fieldnote-shop' ) . '</a></li></ul>';
}
