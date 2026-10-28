<?php
/**
 * Helper functions.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default theme option values (editable in Appearance > Customize > Custom 44).
 */
function c44_defaults() {
	return array(
		'phone'          => '0481 316 944',
		'email'          => 'sales@custom44.com.au',
		'location'       => "Melbourne's South East, VIC",
		'service_area'   => 'Servicing all of Australia',
		'hours'          => '',
		'map_query'      => 'Custom 44 Pty Ltd, Officer VIC',
		'map_cid'        => '10096844181556320685', // Google Business Profile ID for Custom 44 Pty Ltd (pins the exact listing).
		'map_link'       => 'https://www.google.com/maps/place/Custom+44+Pty+Ltd/@-38.0482687,145.4089145,12491m/data=!3m1!1e3!4m8!3m7!1s0x64cdbec35f67126f:0x8c1f3249aa2259ad!8m2!3d-38.0482688!4d145.4089146!9m1!1b1!16s%2Fg%2F11t6xc782n',
		'facebook'       => 'https://www.facebook.com/Custom44Melbourne',
		'instagram'      => 'https://www.instagram.com/custom.44/',
		'google_reviews' => 'https://www.google.com/maps/place/Custom+44+Pty+Ltd/@-38.0482687,145.4089145,12491m/data=!3m1!1e3!4m8!3m7!1s0x64cdbec35f67126f:0x8c1f3249aa2259ad!8m2!3d-38.0482688!4d145.4089146!9m1!1b1!16s%2Fg%2F11t6xc782n',
		'reviews_code'   => '',
		'ig_token'       => '',
		'feed_code'      => '',
		'form_code'      => '',
		'form_to'        => '',
		'announcement'   => 'Save up to <strong>35%</strong> on bulk orders, automatically applied from 5+ items.',
		'hero_title'     => 'Custom workwear, <span class="hl">printed to perform.</span>',
		'hero_text'      => "Melbourne's custom workwear printing specialists. Hi-vis, polos, hoodies and uniforms branded with commercial-grade DTF prints that survive the toughest job sites. Perfect results, every single time.",
		'hero_image'     => '/wp-content/uploads/2026/08/about-custom-44-new-bg-img.jpg',
		'hero_image_2'   => '/wp-content/uploads/2025/09/2.jpg',
		'orders'         => '10000',
		'rating'         => '5.0',
		'review_count'   => '27',
		'logo_fallback'  => '/wp-content/uploads/2025/09/logo-footer.png',
	);
}

/**
 * Get a theme option.
 *
 * @param string $key Option key.
 * @return string
 */
function c44_opt( $key ) {
	$defaults = c44_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'c44_' . $key, $default );
}

/**
 * Turn a site relative upload path into a full URL. Absolute URLs pass through.
 *
 * @param string $path Path or URL.
 * @return string
 */
function c44_img( $path ) {
	if ( is_numeric( $path ) ) {
		$src = wp_get_attachment_image_url( (int) $path, 'large' );
		return $src ? $src : '';
	}
	if ( preg_match( '#^https?://#', $path ) || 0 === strpos( $path, get_template_directory_uri() ) ) {
		return $path;
	}
	return home_url( $path );
}

/**
 * Phone number formatted for tel: links.
 */
function c44_tel() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', c44_opt( 'phone' ) );
}

/**
 * Bulk discount tiers.
 *
 * @return array[] min quantity => discount percent.
 */
function c44_tiers() {
	return apply_filters(
		'c44_tiers',
		array(
			array( 'qty' => 5, 'off' => 15 ),
			array( 'qty' => 10, 'off' => 20 ),
			array( 'qty' => 20, 'off' => 25 ),
			array( 'qty' => 50, 'off' => 30 ),
			array( 'qty' => 100, 'off' => 35 ),
		)
	);
}

/**
 * Logo markup (custom logo, fallback image, or text).
 *
 * @param string $class Extra class.
 */
function c44_logo( $class = '' ) {
	$logo_id = get_theme_mod( 'custom_logo' );
	$name    = get_bloginfo( 'name' );
	echo '<a class="site-logo ' . esc_attr( $class ) . '" href="' . esc_url( home_url( '/' ) ) . '" rel="home" aria-label="' . esc_attr( $name ) . '">';
	if ( $logo_id ) {
		echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => esc_attr( $name ), 'loading' => 'eager' ) );
	} elseif ( c44_opt( 'logo_fallback' ) ) {
		echo '<img src="' . esc_url( c44_img( c44_opt( 'logo_fallback' ) ) ) . '" alt="' . esc_attr( $name ) . '" width="180" height="60">';
	} else {
		echo '<span class="site-logo__text">CUSTOM<span>44</span></span>';
	}
	echo '</a>';
}

/**
 * Category tiles used on the homepage. Pulls the WooCommerce category image when one is set.
 *
 * @return array[]
 */
function c44_home_categories() {
	$items = array(
		array( 'slug' => 'workwear', 'title' => 'Workwear', 'label' => 'Built for site', 'img' => '/wp-content/uploads/2026/10/SW71_OrangeNavy_l.jpg', 'tag' => 'Most ordered' ),
		array( 'slug' => 'best-sellers', 'title' => 'Best Sellers', 'label' => 'Crowd favourites', 'img' => '/wp-content/uploads/2025/12/5001_STAPLE_TEE_ARCTIC_BLUE__41532.1750652269.1280.1280.jpg', 'tag' => '' ),
		array( 'slug' => 'mens', 'title' => 'Mens', 'label' => 'Tees to jackets', 'img' => '/wp-content/uploads/2026/10/FL19_BlkAqua_l.jpg', 'tag' => '' ),
		array( 'slug' => 'womens', 'title' => 'Womens', 'label' => 'Tailored fits', 'img' => '/wp-content/uploads/2025/10/4101_WOS_SUPPLY_HOOD_BLACK__92570.1727138536.1280.1280.jpg', 'tag' => '' ),
		array( 'slug' => 'kids', 'title' => 'Kids', 'label' => 'Schools & clubs', 'img' => '/wp-content/uploads/2026/05/3032_KIDS_SUPPLY_HOOD_ECRU__94694.jpg', 'tag' => '' ),
		array( 'slug' => 'headwear', 'title' => 'Headwear', 'label' => 'Caps & beanies', 'img' => '/wp-content/uploads/2025/10/1103_FINN_FIVE_PANEL_CAP_ARMY__40965.1749690349.1280.1280.jpg', 'tag' => '' ),
	);

	foreach ( $items as &$item ) {
		$item['url']   = home_url( '/product-category/' . $item['slug'] . '/' );
		$item['count'] = '';
		if ( taxonomy_exists( 'product_cat' ) ) {
			$term = get_term_by( 'slug', $item['slug'], 'product_cat' );
			if ( $term && ! is_wp_error( $term ) ) {
				$item['url'] = get_term_link( $term );
				/* translators: %d: number of styles */
				$item['count'] = sprintf( _n( '%d style', '%d styles', $term->count, 'custom44' ), $term->count );
				$thumb_id      = apply_filters( 'c44_use_category_thumbnails', false ) ? get_term_meta( $term->term_id, 'thumbnail_id', true ) : 0;
				if ( $thumb_id ) {
					$src = wp_get_attachment_image_url( $thumb_id, 'large' );
					if ( $src ) {
						$item['img'] = $src;
					}
				}
			}
		}
		$item['img'] = c44_img( $item['img'] );
	}
	return apply_filters( 'c44_home_categories', $items );
}

/**
 * Product brand name (WooCommerce Brands or pa_brand attribute).
 *
 * @param WC_Product $product Product.
 * @return string
 */
function c44_product_brand( $product ) {
	foreach ( array( 'product_brand', 'pwb-brand', 'yith_product_brand' ) as $tax ) {
		if ( taxonomy_exists( $tax ) ) {
			$terms = get_the_terms( $product->get_id(), $tax );
			if ( $terms && ! is_wp_error( $terms ) ) {
				return $terms[0]->name;
			}
		}
	}
	$attr = $product->get_attribute( 'pa_brand' );
	return $attr ? $attr : '';
}

/**
 * Lowest "from" price for a product, used for "From $x" labels.
 *
 * @param WC_Product $product Product.
 * @return string Formatted price HTML or empty.
 */
function c44_from_price( $product ) {
	if ( $product->is_type( 'variable' ) ) {
		$min = $product->get_variation_price( 'min', true );
	} else {
		$min = wc_get_price_to_display( $product );
	}
	return $min ? wc_price( $min ) : '';
}

/**
 * Price range for product cards, matching the current site: "$23.10 - $42.00".
 * Uses a plain hyphen (never an en dash). Single prices show on their own.
 *
 * @param WC_Product $product Product.
 * @return string Price HTML or empty.
 */
function c44_price_range( $product ) {
	if ( $product->is_type( 'variable' ) ) {
		$min = $product->get_variation_price( 'min', true );
		$max = $product->get_variation_price( 'max', true );
	} else {
		$min = wc_get_price_to_display( $product );
		$max = $min;
	}
	if ( ! $min ) {
		return '';
	}
	if ( ! $max || (float) $max <= (float) $min ) {
		return wc_price( $min );
	}
	return wc_price( $min ) . '<span class="c44-range__sep"> - </span>' . wc_price( $max );
}

/**
 * Small garment icon for a print location (tee outline with the print zone highlighted).
 * Front-view zones are drawn from the viewer's side, so Left Chest sits on the right.
 *
 * @param string $label Location name, e.g. "Left Chest", "Centre Back".
 * @return string SVG markup.
 */
function c44_print_location_icon( $label ) {
	$key   = strtolower( trim( preg_replace( '/[^a-z ]/i', '', (string) $label ) ) );
	$zones = array(
		'left chest'   => array( false, '<rect class="zone" x="102" y="56" width="22" height="22" rx="3"/>' ),
		'right chest'  => array( false, '<rect class="zone" x="56" y="56" width="22" height="22" rx="3"/>' ),
		'centre front' => array( false, '<rect class="zone" x="64" y="56" width="52" height="46" rx="4"/>' ),
		'center front' => array( false, '<rect class="zone" x="64" y="56" width="52" height="46" rx="4"/>' ),
		'left sleeve'  => array( false, '<polygon class="zone" points="148,45 144.8,58.3 152.3,63.9 157.3,52.7"/>' ),
		'right sleeve' => array( false, '<polygon class="zone" points="32,45 35.2,58.3 27.7,63.9 22.7,52.7"/>' ),
		'centre back'  => array( true, '<rect class="zone" x="62" y="48" width="56" height="58" rx="4"/>' ),
		'center back'  => array( true, '<rect class="zone" x="62" y="48" width="56" height="58" rx="4"/>' ),
		'lower back'   => array( true, '<rect class="zone" x="66" y="118" width="48" height="20" rx="3"/>' ),
		'upper back'   => array( true, '<rect class="zone" x="66" y="36" width="48" height="18" rx="3"/>' ),
	);
	$zone = isset( $zones[ $key ] ) ? $zones[ $key ] : array( false, '' );
	$tee  = '<path class="tee" d="M62 18 L40 26 L10 52 L26 76 L44 64 L44 150 L136 150 L136 64 L154 76 L170 52 L140 26 L118 18 C112 30 100 34 90 34 C80 34 68 30 62 18 Z"/>';
	$neck = $zone[0] ? '<path class="seam" d="M66 20 C76 26 104 26 114 20"/>' : '<path class="seam" d="M62 18 C68 30 80 36 90 36 C100 36 112 30 118 18"/>';
	return '<svg class="c44-spot__icon" viewBox="0 0 180 160" aria-hidden="true" focusable="false">' . $tee . $neck . $zone[1] . '</svg>';
}

/**
 * Value packs shown on the homepage. Pulls products from the "value-packs" category when
 * it exists; otherwise falls back to the packs currently listed on custom44.com.au.
 *
 * @return array[] name, url, price (number), img, size (pack quantity).
 */
function c44_value_packs() {
	$packs = array();

	if ( class_exists( 'WooCommerce' ) && taxonomy_exists( 'product_cat' ) && get_term_by( 'slug', 'value-packs', 'product_cat' ) && function_exists( 'wc_get_products' ) ) {
		$products = wc_get_products(
			array(
				'status'   => 'publish',
				'limit'    => 40,
				'category' => array( 'value-packs' ),
				'orderby'  => 'menu_order',
				'order'    => 'ASC',
			)
		);
		foreach ( $products as $p ) {
			preg_match( '/(\d+)\s*pack/i', $p->get_name(), $m );
			$packs[] = array(
				'name'  => $p->get_name(),
				'url'   => $p->get_permalink(),
				'price' => (float) wc_get_price_to_display( $p ),
				'img'   => wp_get_attachment_image_url( $p->get_image_id(), 'woocommerce_thumbnail' ),
				'size'  => $m ? (int) $m[1] : 0,
			);
		}
	}

	if ( ! $packs ) {
		$rows = array(
			// name, product slug, price, image file (2026/10 uploads), pack size.
			array( 'AS Colour 7 Pack (Staple / Supply)', 'as7pk-a', 283, '7-PACK-AS-COLOUR.png', 7 ),
			array( 'AS Colour 7 Pack (Classic / Stencil)', 'as7pk-b', 338, '7-STENCIL-PACK-AS338.png', 7 ),
			array( "JB's 7 Pack (Piping Polos + Hoodies)", 'jb7pk-a-jbs-7-pack', 367, '7-PACK-7PIP.png', 7 ),
			array( "JB's 7 Pack (Contrast Polos + Hoodies)", 'jb7pk-b', 375, '7-PACK-7-BEL-.png', 7 ),
			array( "JB's Hi Vis 7 Pack (Hi Vis Polos + Hoodies)", 'jb7pk-hv', 361, '7-PACK-6HSP-.png', 7 ),
			array( 'AS Colour 15 Pack (Staple / Supply)', 'as15pk-a', 535, '15-SUPPLY-PACK-AS535.png', 15 ),
			array( 'AS Colour 15 Pack (Classic / Stencil)', 'as15pk-b', 642, '15-STENCIL-PACK-AS642-1.png', 15 ),
			array( "JB's 15 Pack (Piping Polos + Hoodies)", 'jb15pk-a', 689, '15-PACK-7PIP.png', 15 ),
			array( "JB's 15 Pack (Contrast Polos + Hoodies)", 'jb15pk-b', 705, '7BEL-15-PACK-705.png', 15 ),
			array( "JB's Hi Vis 15 Pack (Hi Vis Polos + Hoodies)", 'jb15pk-hv', 678, 'JB-HIVIS-15-PACK-678.png', 15 ),
			array( 'AS Colour 30 Pack (Staple / Supply)', 'as30pk-a', 1006, '30-SUPPLY-PACK-AS1006.png', 30 ),
			array( 'AS Colour 30 Pack (Classic / Stencil)', 'as30pk-b', 1206, '30-STENCIL-PACK-AS1206-1.png', 30 ),
			array( "JB's 30 Pack (Piping Polos + Hoodies)", 'jb30pk-a', 1295, '30-PACK-7PIP.png', 30 ),
			array( "JB's 30 Pack (Contrast Polos + Hoodies)", 'jb30pk-b', 1324, '7BEL-30-PACK-1324-.png', 30 ),
			array( "JB's Hi Vis 30 Pack (Hi Vis Polos + Hoodies)", 'jb30pk-hv', 1273, '30-PACK-6HSP-.png', 30 ),
			array( 'AS Colour 60 Pack (Staple / Supply)', 'ascolour-60-pack-staple-supply', 1953, '60-STAPLE-PACK-.png', 60 ),
			array( 'AS Colour 60 Pack (Classic / Stencil)', 'ascolour-60-pack-classic-stencil', 2338, '60-STENCIL-PACK-AS2338.png', 60 ),
			array( "JB's 60 Pack (Piping Polos + Hoodies)", 'jbs-60-pack-7pip-3cfh', 2523, '7PIP-60-PACK-1.png', 60 ),
			array( "JB's 60 Pack (Contrast Polos + Hoodies)", 'jbs-60-pack-7bel-3cfh', 2580, '7BEL-60-pack-1.png', 60 ),
			array( "JB's Hi Vis 60 Pack (Hi Vis Polos + Hoodies)", 'jbs-40-pack-hi-vis-6hsp-6hvph', 2480, '60-pack-JB-HIVIS-15-PACK-2480.png', 60 ),
		);
		foreach ( $rows as $r ) {
			$packs[] = array(
				'name'  => $r[0],
				'url'   => 'https://custom44.com.au/product/' . $r[1] . '/',
				'price' => $r[2],
				'img'   => c44_img( '/wp-content/uploads/2026/10/' . $r[3] ),
				'size'  => $r[4],
			);
		}
	}
	return apply_filters( 'c44_value_packs', $packs );
}

/**
 * Google reviews shown on the homepage and product pages (from the Custom 44 Pty Ltd profile).
 *
 * @return array[] name, text.
 */
function c44_google_reviews() {
	return apply_filters(
		'c44_reviews',
		array(
			array( 'Joey taylor', 'I&rsquo;ve had an outstanding experience with this company. The shirt quality is absolutely top-notch really impressive. Service is always friendly and professional, and they consistently give me great prices. They really take care of their customers, and I wouldn&rsquo;t hesitate to recommend them.' ),
			array( 'Cameron Dixon', 'Marko and Maria are so easy to deal with, with quick communication. The product arrived quickly to my door and is fantastic quality. Highly recommend to anyone looking for custom work wear.' ),
			array( 'Nick Keating', 'Custom 44 is so easy to deal with. Marko and Maria were very helpful when I placed my order. Answered any question I had very quickly. Once the mock up was approved I received my order the same week even though I&rsquo;m in a different state. I would highly recommend this company.' ),
			array( 'Cinzia Cailotto', 'Amazing to work with and hoodies and polos are PERFECT. Great quality product and printing. Thank you so much Marko and Maria, you guys are the best every time I order. Balloons and More look so professional in their tops x' ),
			array( 'Brijeshkumar Patel', 'I&rsquo;m very happy with Custom 44. Very fast turnaround, the quality is excellent and very easy to deal with Marko &amp; Maria. Highly recommend.' ),
			array( 'Simon Albore', 'After seeing an advertisement on Facebook I ended up using custom44 to supply and print 50 work shirts for my business. They were easy to deal with, the printing looks great and the T-shirt quality is very good. They even threw in a pack of Allen&rsquo;s Snakes chewie lollies which my family was happy to receive. Would definitely use their services in the future.' ),
		)
	);
}

/**
 * Recent work photos for the homepage gallery: the live Instagram feed when it is
 * connected, otherwise the photos set in Customize > Custom 44 Settings > Recent Work Photos
 * (empty slots fall back to the saved Instagram posts below).
 *
 * @return array[] image, alt text, link.
 */
function c44_recent_work() {
	$feed = c44_instagram_feed( 8 );
	if ( count( $feed ) >= 4 ) {
		return apply_filters( 'c44_recent_work', $feed );
	}

	// Latest @custom.44 posts saved in the theme (assets/images/instagram), each linking to its post.
	$ig       = 'https://www.instagram.com/custom.44/';
	$defaults = array(
		array( 'ig-1.jpg', __( 'Staple Tee flash sale: buy 20, get 5 free', 'custom44' ), $ig . 'reel/DeVNweAj_n6/' ),
		array( 'ig-2.jpg', __( 'New printed gear for a local crew', 'custom44' ), $ig . 'p/DdacC5qCIjj/' ),
		array( 'ig-3.jpg', __( 'Fresh custom merch for spring', 'custom44' ), $ig . 'p/DdXoO-JIzxF/' ),
		array( 'ig-4.jpg', __( 'Bright gradient prints, hot off the press', 'custom44' ), $ig . 'reel/DdTgB-UCUfA/' ),
		array( 'ig-5.jpg', __( 'Gradient logo print on custom merch', 'custom44' ), $ig . 'p/DdSshrBiZ6X/' ),
		array( 'ig-6.jpg', __( 'Uniform upgrade with a printed logo', 'custom44' ), $ig . 'p/DdGdzUJjxl-/' ),
		array( 'ig-7.jpg', __( 'Free cooler bag with your logo printed', 'custom44' ), $ig . 'reel/DdDJAwZDRCt/' ),
		array( 'ig-8.jpg', __( 'Free logo printed cooler bag for every $500 spent', 'custom44' ), $ig . 'p/Db9QrRKksc3/' ),
	);
	$items = array();
	foreach ( $defaults as $i => $d ) {
		$img     = get_theme_mod( 'c44_work_' . ( $i + 1 ), '' );
		$alt     = get_theme_mod( 'c44_work_' . ( $i + 1 ) . '_alt', '' );
		$items[] = array(
			$img ? $img : get_template_directory_uri() . '/assets/images/instagram/' . $d[0],
			$alt ? $alt : $d[1],
			$img ? c44_opt( 'instagram' ) : $d[2],
		);
	}
	return apply_filters( 'c44_recent_work', $items );
}

/**
 * Current Instagram access token. Long-lived tokens last 60 days, so the theme refreshes
 * it about once a week and keeps the newest one in the c44_ig_token option.
 *
 * @return string
 */
function c44_instagram_token() {
	$entered = trim( (string) c44_opt( 'ig_token' ) );
	if ( ! $entered ) {
		return '';
	}
	$stored = get_option( 'c44_ig_token' );
	// A newly entered token (changed in the Customizer) replaces the stored one.
	if ( ! is_array( $stored ) || empty( $stored['token'] ) || ! isset( $stored['source'] ) || md5( $entered ) !== $stored['source'] ) {
		$stored = array( 'token' => $entered, 'source' => md5( $entered ), 'refreshed' => time() );
		update_option( 'c44_ig_token', $stored, false );
	}
	if ( time() - (int) $stored['refreshed'] > WEEK_IN_SECONDS && function_exists( 'wp_remote_get' ) ) {
		$res  = wp_remote_get(
			add_query_arg(
				array( 'grant_type' => 'ig_refresh_token', 'access_token' => $stored['token'] ),
				'https://graph.instagram.com/refresh_access_token'
			),
			array( 'timeout' => 8 )
		);
		$body = is_wp_error( $res ) ? array() : json_decode( wp_remote_retrieve_body( $res ), true );
		if ( ! empty( $body['access_token'] ) ) {
			$stored['token'] = $body['access_token'];
		}
		$stored['refreshed'] = time(); // Try again next week either way.
		update_option( 'c44_ig_token', $stored, false );
	}
	return $stored['token'];
}

/**
 * Latest posts from the Custom 44 Instagram account (Instagram API with Instagram Login).
 * Needs a long-lived access token in Customize > Custom 44 Settings > Social & Reviews.
 * Results are cached for an hour so the homepage stays fast.
 *
 * @param int $limit Number of posts.
 * @return array[] image, alt text, link. Empty when not connected or on error.
 */
function c44_instagram_feed( $limit = 6 ) {
	$token = c44_instagram_token();
	if ( ! $token || ! function_exists( 'wp_remote_get' ) ) {
		return array();
	}
	$cache_key = 'c44_ig_feed_' . $limit;
	$cached    = get_transient( $cache_key );
	if ( false !== $cached ) {
		return $cached;
	}

	$version = apply_filters( 'c44_ig_graph_version', 'v23.0' );
	$res     = wp_remote_get(
		add_query_arg(
			array(
				'fields'       => 'id,media_type,media_url,thumbnail_url,permalink,caption',
				'limit'        => 20,
				'access_token' => $token,
			),
			'https://graph.instagram.com/' . $version . '/me/media'
		),
		array( 'timeout' => 8 )
	);
	$items = array();
	if ( ! is_wp_error( $res ) && 200 === (int) wp_remote_retrieve_response_code( $res ) ) {
		$body = json_decode( wp_remote_retrieve_body( $res ), true );
		foreach ( (array) ( isset( $body['data'] ) ? $body['data'] : array() ) as $post ) {
			$is_video = isset( $post['media_type'] ) && 'VIDEO' === $post['media_type'];
			$img      = $is_video ? ( isset( $post['thumbnail_url'] ) ? $post['thumbnail_url'] : '' ) : ( isset( $post['media_url'] ) ? $post['media_url'] : '' );
			if ( ! $img ) {
				continue;
			}
			$text    = isset( $post['caption'] ) ? wp_strip_all_tags( $post['caption'] ) : '';
			$items[] = array(
				esc_url_raw( $img ),
				$text ? wp_trim_words( $text, 14, '...' ) : __( 'Custom 44 on Instagram', 'custom44' ),
				isset( $post['permalink'] ) ? esc_url_raw( $post['permalink'] ) : c44_opt( 'instagram' ),
			);
			if ( count( $items ) >= $limit ) {
				break;
			}
		}
		set_transient( $cache_key, $items, HOUR_IN_SECONDS );
	} else {
		// Try again in 10 minutes rather than calling Instagram on every page view.
		set_transient( $cache_key, array(), 10 * MINUTE_IN_SECONDS );
	}
	return $items;
}
