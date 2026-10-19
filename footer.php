<?php
/**
 * Global footer (includes the contact section directly above it).
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_cat = function ( $slug ) {
	return home_url( '/product-category/' . $slug . '/' );
};
?>
</main>

<?php get_template_part( 'template-parts/contact-section' ); ?>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<?php c44_logo( 'site-logo--footer' ); ?>
				<p><?php esc_html_e( "Family owned apparel decoration and workwear printing in Melbourne's South East. Commercial-grade DTF prints on rugged garments, dispatched Australia-wide.", 'custom44' ); ?></p>
				<div class="footer-social">
					<?php if ( c44_opt( 'facebook' ) ) : ?>
						<a href="<?php echo esc_url( c44_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php c44_the_icon( 'facebook' ); ?></a>
					<?php endif; ?>
					<?php if ( c44_opt( 'instagram' ) ) : ?>
						<a href="<?php echo esc_url( c44_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php c44_the_icon( 'instagram' ); ?></a>
					<?php endif; ?>
					<?php if ( c44_opt( 'google_reviews' ) ) : ?>
						<a href="<?php echo esc_url( c44_opt( 'google_reviews' ) ); ?>" target="_blank" rel="noopener" aria-label="Google reviews"><?php c44_the_icon( 'google' ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Shop', 'custom44' ); ?></h4>
				<?php
				c44_footer_menu(
					'footer_shop',
					array(
						'Best Sellers' => $c44_cat( 'best-sellers' ),
						'Workwear'     => $c44_cat( 'workwear' ),
						'Mens'         => $c44_cat( 'mens' ),
						'Womens'       => $c44_cat( 'womens' ),
						'Kids'         => $c44_cat( 'kids' ),
						'Headwear'     => $c44_cat( 'headwear' ),
					)
				);
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Helpful Links', 'custom44' ); ?></h4>
				<?php
				c44_footer_menu(
					'footer_help',
					array(
						'Contact'            => home_url( '/contact/' ),
						'DTF Print Care'     => home_url( '/dtf-print-care/' ),
						'Refund Policy'      => home_url( '/refund-policy/' ),
						'Privacy Policy'     => home_url( '/privacy-policy/' ),
						'Terms & Conditions' => home_url( '/terms-conditions/' ),
						'Sitemap'            => home_url( '/user-sitemap/' ),
					)
				);
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Contact', 'custom44' ); ?></h4>
				<ul class="footer-contact">
					<li><?php c44_the_icon( 'phone' ); ?><a href="<?php echo esc_attr( c44_tel() ); ?>"><?php echo esc_html( c44_opt( 'phone' ) ); ?></a></li>
					<li><?php c44_the_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( c44_opt( 'email' ) ); ?>"><?php echo esc_html( c44_opt( 'email' ) ); ?></a></li>
					<li><?php c44_the_icon( 'pin' ); ?><span><?php echo esc_html( c44_opt( 'location' ) ); ?><br><?php echo esc_html( c44_opt( 'service_area' ) ); ?></span></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="footer-big" aria-hidden="true">CUSTOM<span>44</span></div>

	<div class="footer-bottom">
		<div class="container footer-bottom__inner">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'custom44' ); ?></span>
			<span><?php esc_html_e( 'Designed by', 'custom44' ); ?> <a href="https://www.digitalmovement.com.au/" target="_blank" rel="noopener">Digital Movement</a></span>
		</div>
	</div>
</footer>

<a class="mobile-call" href="<?php echo esc_attr( c44_tel() ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Call now on %s', 'custom44' ), c44_opt( 'phone' ) ) ); ?>">
	<span class="mobile-call__icon"><?php c44_the_icon( 'phone' ); ?></span>
	<?php esc_html_e( 'Call Now', 'custom44' ); ?>
</a>

<button class="to-top" type="button" aria-label="<?php esc_attr_e( 'Scroll to top', 'custom44' ); ?>">
	<svg class="to-top__ring" viewBox="0 0 64 64" aria-hidden="true"><circle cx="32" cy="32" r="30"></circle></svg>
	<?php c44_the_icon( 'arrow', 'to-top__arrow' ); ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
