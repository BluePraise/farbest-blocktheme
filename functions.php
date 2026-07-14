<?php
/**
 * Farbest Block Theme functions.
 *
 * @package farbest-block-theme
 */

require_once get_template_directory() . '/inc/card-grid-block.php';

function farbest_block_theme_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_editor_style( 'css/tokens.css' );
	register_block_pattern_category( 'farbest', array( 'label' => __( 'Farbest', 'farbest-block-theme' ) ) );
}
add_action( 'after_setup_theme', 'farbest_block_theme_setup' );

/**
 * File-modification-time based asset version for cache busting.
 *
 * Returns the file's mtime so browsers and CDNs fetch a fresh copy whenever the
 * asset changes, instead of relying on a manually bumped version string.
 *
 * @param string $relative_path Path relative to the theme root, e.g. 'css/global.css'.
 * @return string Version string.
 */
function farbest_asset_version( $relative_path ) {
	$file = get_template_directory() . '/' . ltrim( $relative_path, '/' );
	return file_exists( $file ) ? (string) filemtime( $file ) : '1.0.0';
}

function farbest_block_theme_register_styles() {
	wp_register_style(
		'farbest-tokens',
		get_template_directory_uri() . '/css/tokens.css',
		array(),
		farbest_asset_version( 'css/tokens.css' )
	);
}
add_action( 'init', 'farbest_block_theme_register_styles', 5 );

/**
 * Register dynamic header utility blocks to keep raw HTML out of Site Editor.
 */
function farbest_register_header_utility_blocks() {
	register_block_type(
		'farbest/hamburger-button',
		array(
			'api_version'      => 3,
			'title'            => __( 'Farbest Hamburger Button', 'farbest-block-theme' ),
			'category'         => 'farbest',
			'supports'         => array(
				'html'     => false,
				'inserter' => false,
			),
			'render_callback'  => 'farbest_render_hamburger_button',
		)
	);

	register_block_type(
		'farbest/mobile-menu',
		array(
			'api_version'      => 3,
			'title'            => __( 'Farbest Mobile Menu', 'farbest-block-theme' ),
			'category'         => 'farbest',
			'supports'         => array(
				'html'     => false,
				'inserter' => false,
			),
			'render_callback'  => 'farbest_render_mobile_menu',
		)
	);
}
add_action( 'init', 'farbest_register_header_utility_blocks' );

/**
 * Render callback for farbest/hamburger-button.
 */
function farbest_render_hamburger_button() {
	return '<button class="farbest-header__hamburger" aria-label="Open menu" aria-expanded="false" aria-controls="farbest-mobile-menu"><span class="farbest-header__hamburger-line"></span><span class="farbest-header__hamburger-line"></span><span class="farbest-header__hamburger-line"></span></button>';
}

/**
 * Render callback for farbest/mobile-menu.
 */
function farbest_render_mobile_menu() {
	return '<div class="farbest-mobile-menu" id="farbest-mobile-menu" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Mobile navigation"><button class="farbest-mobile-menu__close" aria-label="Close menu"><span class="farbest-mobile-menu__close-line"></span><span class="farbest-mobile-menu__close-line"></span></button><nav class="farbest-mobile-menu__nav" aria-label="Mobile primary navigation"></nav></div><div class="farbest-mobile-overlay" id="farbest-mobile-overlay" aria-hidden="true"></div>';
}

add_filter( 'block_categories_all', function ( $categories ) {
	foreach ( $categories as $cat ) {
		if ( 'farbest' === $cat['slug'] ) {
			return $categories;
		}
	}
	return array_merge(
		array( array( 'slug' => 'farbest', 'title' => 'Farbest', 'icon' => null ) ),
		$categories
	);
}, 9 );

function farbest_enqueue_card_grid_block_style() {
	wp_enqueue_block_style( 'farbest/card-grid', array(
		'handle' => 'farbest-card-grid',
		'src'    => get_template_directory_uri() . '/css/card-grid.css',
		'deps'   => array( 'farbest-tokens' ),
		'ver'    => farbest_asset_version( 'css/card-grid.css' ),
	) );
}
add_action( 'init', 'farbest_enqueue_card_grid_block_style' );


function farbest_block_theme_styles() {
	wp_enqueue_style(
		'farbest-open-sans',
		'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'farbest-tokens' );

	wp_enqueue_style(
		'farbest-global',
		get_template_directory_uri() . '/css/global.css',
		array( 'farbest-tokens' ),
		farbest_asset_version( 'css/global.css' )
	);

	wp_enqueue_style(
		'farbest-header',
		get_template_directory_uri() . '/css/header.css',
		array( 'farbest-tokens' ),
		farbest_asset_version( 'css/header.css' )
	);

	wp_enqueue_style(
		'farbest-footer',
		get_template_directory_uri() . '/css/footer.css',
		array( 'farbest-tokens' ),
		farbest_asset_version( 'css/footer.css' )
	);

	if ( is_singular( 'fpc_ingredient' ) ) {
		wp_enqueue_style(
			'farbest-ingredient-single',
			get_template_directory_uri() . '/css/ingredient-single.css',
			array( 'farbest-tokens' ),
			farbest_asset_version( 'css/ingredient-single.css' )
		);
	}

	wp_enqueue_script(
		'farbest-header',
		get_template_directory_uri() . '/js/header.js',
		array(),
		farbest_asset_version( 'js/header.js' ),
		true
	);

}
add_action( 'wp_enqueue_scripts', 'farbest_block_theme_styles' );

/**
 * Render the plugin's ingredient template as post content on the block theme.
 *
 * The block template (single-fpc_ingredient.html) uses wp:post-content to
 * render the main area. This filter replaces that empty content with the
 * plugin's rendered HTML, keeping header/footer in the block theme's template
 * parts. The plugin's FPC_Template_Loader::render_single() handles ob_start
 * and template path resolution — the theme does not need to know either.
 */
function farbest_render_ingredient_content( $content ) {
	if ( ! is_singular( 'fpc_ingredient' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( ! class_exists( 'FPC_Template_Loader' ) ) {
		return $content;
	}

	return FPC_Template_Loader::render_single();
}
add_filter( 'the_content', 'farbest_render_ingredient_content' );
