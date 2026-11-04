<?php
/**
 * Site footer.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer">
	<div class="wrap site-footer__inner">
		<p class="site-footer__name"><?php bloginfo( 'name' ); ?></p>
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Footer', 'fieldnote-shop' ); ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1 ) ); ?>
			</nav>
		<?php endif; ?>
		<p class="site-footer__legal">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
