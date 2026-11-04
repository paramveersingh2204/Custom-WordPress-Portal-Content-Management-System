<?php
/**
 * Home hero. All copy and the image come from ACF fields.
 * An empty "Hero image description" renders the image as decorative (alt="").
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

$heading   = fns_field( 'hero_heading', false, get_bloginfo( 'name' ) );
$text      = fns_field( 'hero_text' );
$image_id  = (int) fns_field( 'hero_image' );
$image_alt = fns_field( 'hero_image_alt' );
$cta_label = fns_field( 'hero_cta_label' );
$cta_url   = fns_field( 'hero_cta_url' );
?>
<section class="hero" aria-labelledby="hero-title">
	<div class="wrap hero__inner">
		<div class="hero__copy">
			<h1 id="hero-title"><?php echo esc_html( $heading ); ?></h1>
			<?php if ( $text ) : ?>
				<p class="hero__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<?php if ( $cta_label && $cta_url ) : ?>
				<p><a class="button button--lg" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a></p>
			<?php endif; ?>
		</div>
		<?php if ( $image_id ) : ?>
			<div class="hero__media">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'fns-hero',
					false,
					array(
						'alt'           => $image_alt,
						'loading'       => 'eager',
						'fetchpriority' => 'high',
					)
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
