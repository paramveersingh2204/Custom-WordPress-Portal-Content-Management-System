<?php
/**
 * Product card. The title link is stretched over the whole card (one link per card,
 * no duplicate image link), and the image is decorative because the title names it.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

$product_id = isset( $args['product_id'] ) ? (int) $args['product_id'] : 0;
$product    = $product_id ? wc_get_product( $product_id ) : false;
if ( ! $product ) {
	return;
}
$badge  = fns_field( 'product_badge', $product_id );
$labels = array(
	'new'     => __( 'New', 'fieldnote-shop' ),
	'limited' => __( 'Limited run', 'fieldnote-shop' ),
	'restock' => __( 'Back in stock', 'fieldnote-shop' ),
);
?>
<article class="card">
	<div class="card__media">
		<?php echo wp_kses_post( $product->get_image( 'fns-card', array( 'alt' => '' ) ) ); ?>
		<?php if ( isset( $labels[ $badge ] ) ) : ?>
			<span class="badge badge--<?php echo esc_attr( $badge ); ?>"><?php echo esc_html( $labels[ $badge ] ); ?></span>
		<?php endif; ?>
	</div>
	<h3 class="card__title"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
	<p class="card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
</article>
