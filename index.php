<?php
/**
 * Fallback template for posts, pages and archives.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="page-hero">
	<div class="hero__bg" aria-hidden="true"></div>
	<div class="hero__grid-lines" aria-hidden="true"></div>
	<div class="container">
		<span class="eyebrow"><?php bloginfo( 'name' ); ?></span>
		<h1>
			<?php
			if ( is_singular() ) {
				single_post_title();
			} elseif ( is_search() ) {
				/* translators: %s: search query */
				printf( esc_html__( 'Results for "%s"', 'custom44' ), esc_html( get_search_query() ) );
			} elseif ( is_404() ) {
				esc_html_e( 'Page not found', 'custom44' );
			} else {
				the_archive_title();
			}
			?>
		</h1>
	</div>
</section>

<div class="container entry">
	<div class="entry-content<?php echo ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) ? ' entry-content--wide' : ''; ?>">
		<?php
		if ( have_posts() && ! is_404() ) :
			while ( have_posts() ) :
				the_post();
				if ( is_singular() ) :
					the_content();
					wp_link_pages();
				else :
					?>
					<article <?php post_class(); ?> style="margin-bottom:40px">
						<h2 class="h-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
					<?php
				endif;
			endwhile;
			the_posts_pagination();
		else :
			?>
			<p class="lead"><?php esc_html_e( 'Sorry, we could not find what you were looking for.', 'custom44' ); ?></p>
			<a class="btn btn--accent" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'custom44' ); ?></a>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
