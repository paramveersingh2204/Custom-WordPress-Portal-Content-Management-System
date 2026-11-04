<?php
/**
 * Site header: skip link, live region, announcement, banner, primary nav, cart.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
$announcement = get_theme_mod( 'fns_announcement', '' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to main content', 'fieldnote-shop' ); ?></a>
<div id="fns-status" class="screen-reader-text" role="status" aria-live="polite" aria-atomic="true"></div>

<?php if ( $announcement ) : ?>
	<p class="announcement"><?php echo esc_html( $announcement ); ?></p>
<?php endif; ?>

<header class="site-header">
	<div class="wrap site-header__inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</div>

		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu-wrap">
			<?php esc_html_e( 'Menu', 'fieldnote-shop' ); ?>
		</button>

		<div id="primary-menu-wrap" class="primary-nav">
			<nav aria-label="<?php esc_attr_e( 'Primary', 'fieldnote-shop' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => 'fns_menu_fallback',
						'depth'          => 2,
					)
				);
				?>
			</nav>
			<?php get_search_form(); ?>
		</div>

		<?php if ( function_exists( 'WC' ) ) : ?>
			<a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
				<?php esc_html_e( 'Cart', 'fieldnote-shop' ); ?>
				<span class="cart-count" data-cart-count><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
				<span class="screen-reader-text"><?php esc_html_e( 'items, view cart', 'fieldnote-shop' ); ?></span>
			</a>
		<?php endif; ?>
	</div>
</header>
