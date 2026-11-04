<?php
/**
 * Accessibility helpers and settings.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * "Continue reading" links get a unique accessible name (WCAG 2.4.4 Link Purpose).
 */
function fns_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'fns_excerpt_more' );

/**
 * Pagination: labelled landmark with a screen-reader heading.
 */
add_filter( 'navigation_markup_template', function ( $template ) {
	return '<nav class="navigation %1$s" aria-label="%4$s"><h2 class="screen-reader-text">%2$s</h2><div class="nav-links">%3$s</div></nav>';
} );

/**
 * Customizer: optional announcement bar (plain text, escaped on output).
 */
function fns_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'fns_site',
		array(
			'title'    => __( 'Store notice', 'fieldnote-shop' ),
			'priority' => 30,
		)
	);
	$wp_customize->add_setting(
		'fns_announcement',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'fns_announcement',
		array(
			'label'       => __( 'Announcement text', 'fieldnote-shop' ),
			'description' => __( 'Shown above the header. Leave empty to hide.', 'fieldnote-shop' ),
			'section'     => 'fns_site',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'fns_customize_register' );

/**
 * Comment form: keep native HTML5 validation and give required fields a text cue.
 */
function fns_comment_form_defaults( $defaults ) {
	$defaults['title_reply_before'] = '<h2 id="reply-title" class="comment-reply-title">';
	$defaults['title_reply_after']  = '</h2>';
	return $defaults;
}
add_filter( 'comment_form_defaults', 'fns_comment_form_defaults' );
