<?php
/**
 * ACF field groups, registered in code so they are version-controlled.
 * Needs the free "Advanced Custom Fields" plugin (6.x). The theme still renders without it.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

function fns_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// 1. Home page hero -------------------------------------------------
	acf_add_local_field_group(
		array(
			'key'      => 'group_fns_home_hero',
			'title'    => 'Home page: hero and featured products',
			'fields'   => array(
				array( 'key' => 'field_fns_hero_heading', 'label' => 'Hero heading', 'name' => 'hero_heading', 'type' => 'text', 'required' => 1 ),
				array( 'key' => 'field_fns_hero_text', 'label' => 'Hero text', 'name' => 'hero_text', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_fns_hero_image', 'label' => 'Hero image', 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium' ),
				array(
					'key'          => 'field_fns_hero_image_alt',
					'label'        => 'Hero image description',
					'name'         => 'hero_image_alt',
					'type'         => 'text',
					'instructions' => 'Describe what the image shows for screen-reader users. Leave empty if the image is purely decorative.',
				),
				array( 'key' => 'field_fns_hero_cta_label', 'label' => 'Button text', 'name' => 'hero_cta_label', 'type' => 'text', 'instructions' => 'Say what happens, e.g. "Shop notebooks".' ),
				array( 'key' => 'field_fns_hero_cta_url', 'label' => 'Button link', 'name' => 'hero_cta_url', 'type' => 'url' ),
				array( 'key' => 'field_fns_featured_heading', 'label' => 'Featured section heading', 'name' => 'featured_heading', 'type' => 'text' ),
				array(
					'key'           => 'field_fns_featured_products',
					'label'         => 'Featured products',
					'name'          => 'featured_products',
					'type'          => 'relationship',
					'post_type'     => array( 'product' ),
					'min'           => 0,
					'max'           => 4,
					'return_format' => 'id',
					'instructions'  => 'Pick up to four. Empty = WooCommerce featured products, then newest.',
				),
			),
			'location' => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
		)
	);

	// 2. Product details ------------------------------------------------
	acf_add_local_field_group(
		array(
			'key'      => 'group_fns_product',
			'title'    => 'Product details',
			'fields'   => array(
				array(
					'key'           => 'field_fns_product_badge',
					'label'         => 'Badge',
					'name'          => 'product_badge',
					'type'          => 'select',
					'choices'       => array(
						''        => 'None',
						'new'     => 'New',
						'limited' => 'Limited run',
						'restock' => 'Back in stock',
					),
					'allow_null'    => 0,
					'return_format' => 'value',
				),
				array( 'key' => 'field_fns_product_material', 'label' => 'Materials', 'name' => 'product_material', 'type' => 'text' ),
				array( 'key' => 'field_fns_product_dimensions', 'label' => 'Dimensions', 'name' => 'product_dimensions', 'type' => 'text', 'placeholder' => '148 x 210 mm' ),
				array( 'key' => 'field_fns_product_care', 'label' => 'Care instructions', 'name' => 'product_care', 'type' => 'textarea', 'rows' => 3, 'new_lines' => 'wpautop' ),
				array( 'key' => 'field_fns_product_eco', 'label' => 'Made with recycled materials', 'name' => 'product_eco', 'type' => 'true_false', 'ui' => 1 ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'product' ) ) ),
			'position' => 'normal',
		)
	);

	// 3. Page intro (all regular pages) ---------------------------------
	acf_add_local_field_group(
		array(
			'key'      => 'group_fns_page_intro',
			'title'    => 'Page intro',
			'fields'   => array(
				array( 'key' => 'field_fns_page_intro', 'label' => 'Intro sentence', 'name' => 'page_intro', 'type' => 'text', 'instructions' => 'One short sentence shown under the page title.' ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ) ) ),
		)
	);
}
add_action( 'acf/init', 'fns_register_acf_fields' );
