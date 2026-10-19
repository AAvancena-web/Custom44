<?php
/**
 * Global header.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_cart_url   = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' );
$c44_cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
$c44_account    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0b0c0e">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'custom44' ); ?></a>

<div class="topbar">
	<div class="container topbar__inner">
		<p class="topbar__msg"><span class="topbar__pulse" aria-hidden="true"></span><span><?php echo wp_kses_post( c44_opt( 'announcement' ) ); ?></span></p>
		<div class="topbar__links">
			<a href="mailto:<?php echo esc_attr( c44_opt( 'email' ) ); ?>"><?php c44_the_icon( 'mail' ); ?><?php echo esc_html( c44_opt( 'email' ) ); ?></a>
			<a href="<?php echo esc_url( $c44_account ); ?>"><?php c44_the_icon( 'user' ); ?><?php esc_html_e( 'Login', 'custom44' ); ?></a>
			<?php if ( c44_opt( 'facebook' ) ) : ?>
				<a href="<?php echo esc_url( c44_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php c44_the_icon( 'facebook' ); ?></a>
			<?php endif; ?>
			<?php if ( c44_opt( 'instagram' ) ) : ?>
				<a href="<?php echo esc_url( c44_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php c44_the_icon( 'instagram' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<header class="site-header" id="site-header">
	<div class="scroll-progress" aria-hidden="true"></div>
	<div class="container site-header__inner">
		<?php c44_logo(); ?>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'custom44' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'depth'          => 2,
					'fallback_cb'    => 'c44_primary_fallback',
				)
			);
			?>
		</nav>

		<div class="header-actions">
			<button class="icon-btn" type="button" data-search-toggle aria-expanded="false" aria-controls="search-panel" aria-label="<?php esc_attr_e( 'Search products', 'custom44' ); ?>"><?php c44_the_icon( 'search' ); ?></button>
			<a class="icon-btn icon-btn--account" href="<?php echo esc_url( $c44_account ); ?>" aria-label="<?php esc_attr_e( 'My account', 'custom44' ); ?>"><?php c44_the_icon( 'user' ); ?></a>
			<a class="icon-btn" href="<?php echo esc_url( $c44_cart_url ); ?>" aria-label="<?php esc_attr_e( 'Quote cart', 'custom44' ); ?>">
				<?php c44_the_icon( 'bag' ); ?>
				<span class="icon-btn__count c44-cart-count"><?php echo esc_html( $c44_cart_count ); ?></span>
			</a>
			<a class="btn btn--accent btn--sm header-cta" href="#contact"><?php esc_html_e( 'Get a Free Quote', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
			<div class="header-phone-wrap">
				<a class="header-phone" href="<?php echo esc_attr( c44_tel() ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Call %s', 'custom44' ), c44_opt( 'phone' ) ) ); ?>"><?php c44_the_icon( 'phone' ); ?></a>
				<a class="header-phone-text" href="<?php echo esc_attr( c44_tel() ); ?>"><small><?php esc_html_e( 'Call us', 'custom44' ); ?></small><strong><?php echo esc_html( c44_opt( 'phone' ) ); ?></strong></a>
			</div>
			<button class="hamburger" type="button" data-drawer-toggle aria-expanded="false" aria-controls="mobile-drawer" aria-label="<?php esc_attr_e( 'Open menu', 'custom44' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>

	<div class="search-panel" id="search-panel">
		<div class="container">
			<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="c44-search"><?php esc_html_e( 'Search for:', 'custom44' ); ?></label>
				<input type="search" id="c44-search" name="s" placeholder="<?php esc_attr_e( 'Search tees, polos, hi-vis, hoodies...', 'custom44' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<input type="hidden" name="post_type" value="product">
				<?php endif; ?>
				<button class="btn btn--dark" type="submit"><?php esc_html_e( 'Search', 'custom44' ); ?></button>
			</form>
		</div>
	</div>
</header>

<div class="drawer-overlay" data-drawer-close></div>
<aside class="mobile-drawer" id="mobile-drawer" aria-label="<?php esc_attr_e( 'Mobile menu', 'custom44' ); ?>" aria-hidden="true">
	<div class="mobile-drawer__head">
		<?php c44_logo( 'site-logo--drawer' ); ?>
		<button class="mobile-drawer__close" type="button" data-drawer-close aria-label="<?php esc_attr_e( 'Close menu', 'custom44' ); ?>"><?php c44_the_icon( 'close' ); ?></button>
	</div>
	<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile', 'custom44' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'depth'          => 2,
				'fallback_cb'    => 'c44_primary_fallback',
			)
		);
		?>
	</nav>
	<div class="mobile-drawer__foot">
		<a class="btn btn--accent btn--block" href="#contact" data-drawer-close><?php esc_html_e( 'Get a Free Quote', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
		<a class="btn btn--white btn--block" href="<?php echo esc_attr( c44_tel() ); ?>"><?php c44_the_icon( 'phone' ); ?><?php echo esc_html( c44_opt( 'phone' ) ); ?></a>
		<p><?php echo esc_html( c44_opt( 'email' ) ); ?></p>
	</div>
</aside>

<main id="main" class="site-main">
