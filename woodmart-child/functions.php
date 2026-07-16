<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'woodmart-style' ),
		woodmart_get_theme_info( 'Version' )
	);
    wp_enqueue_style(
        'child-custom-style',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/css/custom.css')
    );
    
    // Enqueue Local Swiper and Tailwind styles/scripts
    wp_enqueue_style(
        'swiper-local-css',
        get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );
    wp_enqueue_style(
        'derwaza-tailwind-css',
        get_stylesheet_directory_uri() . '/assets/css/tailwind.css',
        array(),
        '1.0.0'
    );
    wp_enqueue_script(
        'swiper-local-js',
        get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );
    wp_enqueue_script(
        'derwaza-blocks-js',
        get_stylesheet_directory_uri() . '/assets/js/custom-blocks.js',
        array('swiper-local-js'),
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

add_action( 'template_redirect', 'force_modify_product_html_output' );

function force_modify_product_html_output() {
	if ( ! is_product() ) return;

	ob_start( 'custom_product_html_filter' );
}

function custom_product_html_filter( $html ) {
	// داخل صفحات المنتجات فقط
	$html = preg_replace_callback(
		'/(<div class="elementor-widget-container">.*?<\/div>)/is',
		function ( $matches ) {
			$block = $matches[1];

			// استبدال <p> بعنصر span داخل <li>
			$block = preg_replace(
				'/<p[^>]*>(.*?)<\/p>/is',
				'<li><span class="short-desc-item">$1</span></li>',
				$block
			);

			// استبدال <li> النصوص بداخل span
			$block = preg_replace(
				'/<li[^>]*>(.*?)<\/li>/is',
				'<li><span class="short-desc-item">$1</span></li>',
				$block
			);

			// توحيد أي H1~H6 إلى span
			$block = preg_replace(
				'/<h[1-6][^>]*>(.*?)<\/h[1-6]>/is',
				'<span class="short-desc-item">$1</span>',
				$block
			);

			return $block;
		},
		$html
	);

	return $html;
}
add_filter('woobe_set_per_page_values', function($values) {
    // Standard values: 10, 25, 50, 100
    // Adding custom values:
    $values = "10,25,50,100,150,300"; 
    
    return $values;
});


add_shortcode('dynamic_svg_stars', function() {
    global $product;
    if ( ! $product ) return '';
    
    $rating = $product->get_average_rating();
    
    if ( $rating <= 0 ) {
        return '<div class="custom-svg-rating-container" style="visibility: hidden; height: 24px;"></div>';
    }

    $rating_val = round($rating);
    $svg_star = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#FFD700">
                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/>
                 </svg>';

    $output = '<div class="custom-svg-rating-container">';
    $output .= '<span class="rating-number">' . number_format($rating, 1) . '</span>';
    $output .= '<div class="stars-wrapper">';
    for ( $i = 1; $i <= $rating_val; $i++ ) {
        $output .= $svg_star;
    }
    $output .= '</div></div>';

    return $output;
});


add_shortcode('product_discount_badge', function() {
    global $product;
    if (!$product || !$product->is_on_sale()) return '';

    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();

    if (!$regular_price || !$sale_price) return '';

    $percentage = round((( (float)$regular_price - (float)$sale_price ) / (float)$regular_price ) * 100);

    if ($percentage <= 0) return '';

    return '<div class="custom-discount-badge">-' . $percentage . '%</div>';
});

add_shortcode('short_product_title', function() {
    global $product;
    if ( ! $product ) return '';

    $title = $product->get_name();
    $limit = 3;
    
    $words = explode(' ', $title);
    if (count($words) > $limit) {
        $title = implode(' ', array_slice($words, 0, $limit));
    }

    return '<h3 class="custom-product-title">' . $title . '</h3>';
});


add_shortcode('top_header_features', function() {
    return '
    <div class="top-header-bar">
        <div class="top-header-container">
            <div class="header-left-side">
                <div class="lang-item">العربية <img src="https://flagcdn.com/w20/kw.png" alt="Kuwait"></div>
                <div class="lang-divider"></div>
                <div class="lang-item">العربية</div>
            </div>
            <div class="header-right-side">
                <div class="info-item">
                    <span>منتجات أصلية 100%</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="#43a047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>
                </div>
                <div class="info-item">
                    <span>دفع عند الاستلام</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="#43a047" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line><path d="M7 15h.01"></path><path d="M11 15h.01"></path></svg>
                </div>
                <div class="info-item">
                    <span>توصيل سريع خلال 24 ساعة</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 32 32" fill="#43a047"><title >free-shipping</title><path d="M32 19.8c0-1.37-0.8-2.56-2-3.23v-3.87l-3.13-4.7h-4.87v-3h-19v2h17v11h7.81c1.21 0 2.19 0.81 2.19 1.8v3.2h-3.15c-0.44-1.57-1.87-2.72-3.57-2.72s-3.12 1.15-3.57 2.71h-10.42c-0.44-1.56-1.87-2.71-3.57-2.71-2.050 0-3.72 1.67-3.72 3.72s1.67 3.72 3.72 3.72c1.71 0 3.14-1.16 3.57-2.73h10.41c0.44 1.57 1.87 2.73 3.57 2.73s3.13-1.16 3.57-2.72h5.16v-5.2zM5.72 25.72c-0.95 0-1.72-0.77-1.72-1.72s0.77-1.72 1.72-1.72 1.73 0.77 1.73 1.72-0.78 1.72-1.73 1.72zM23.28 25.72c-0.95 0-1.72-0.77-1.72-1.72s0.77-1.72 1.72-1.72 1.72 0.77 1.72 1.72-0.77 1.72-1.72 1.72zM25.42 16h-3.42v-6h3.8l2.2 3.3v2.7h-2.58z" /><path d="M0 11h9.53v2h-9.53v-2z" /><path d="M6 16h10.89v2h-10.89v-2z" /></svg>
                </div>
            </div>
        </div>
    </div>';
});

// Require custom functions to register Gutenberg blocks dynamically in the child theme
require_once get_stylesheet_directory() . '/inc/custom-functions.php';