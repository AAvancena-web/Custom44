<?php
/**
 * Google reviews panel for the product page tabs.
 * Reviews come from c44_google_reviews() (filterable), or a reviews widget shortcode
 * set in Appearance > Customize > Custom 44 Settings > Social & Reviews.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_reviews = c44_google_reviews();
$c44_count   = c44_opt( 'review_count' );
?>
<div class="g-reviews">
	<div class="g-reviews__summary">
		<span class="g-reviews__logo"><?php c44_the_icon( 'google' ); ?></span>
		<div>
			<strong class="g-reviews__score"><?php echo esc_html( c44_opt( 'rating' ) ); ?></strong>
			<?php echo c44_stars(); // phpcs:ignore ?>
			<span class="g-reviews__count">
				<?php
				/* translators: %s: number of reviews */
				echo esc_html( $c44_count ? sprintf( __( 'Based on %s Google reviews', 'custom44' ), $c44_count ) : __( 'Google reviews', 'custom44' ) );
				?>
			</span>
		</div>
		<a class="btn btn--dark btn--sm" href="<?php echo esc_url( c44_opt( 'google_reviews' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Read all on Google', 'custom44' ); ?></a>
	</div>

	<?php if ( c44_opt( 'reviews_code' ) ) : ?>
		<div class="reviews-embed"><?php echo do_shortcode( wp_kses_post( c44_opt( 'reviews_code' ) ) ); ?></div>
	<?php else : ?>
		<div class="g-reviews__list">
			<?php foreach ( array_slice( $c44_reviews, 0, 4 ) as $c44_r ) : ?>
				<figure class="g-review">
					<div class="g-review__head">
						<span class="review-card__avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $c44_r[0], 0, 1 ) ); ?></span>
						<span><b><?php echo esc_html( $c44_r[0] ); ?></b><?php echo c44_stars(); // phpcs:ignore ?></span>
					</div>
					<blockquote><?php echo wp_kses_post( $c44_r[1] ); ?></blockquote>
				</figure>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
