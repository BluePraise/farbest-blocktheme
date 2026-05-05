<?php
/**
 * Farbest Block Theme functions.
 *
 * @package farbest-block-theme
 */

function farbest_block_theme_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/tokens.css' );
}
add_action( 'after_setup_theme', 'farbest_block_theme_setup' );

function farbest_block_theme_styles() {
	wp_enqueue_style(
		'farbest-tokens',
		get_template_directory_uri() . '/css/tokens.css',
		array(),
		'1.0.0'
	);

	wp_enqueue_style(
		'farbest-header',
		get_template_directory_uri() . '/css/header.css',
		array( 'farbest-tokens' ),
		'1.0.0'
	);

	wp_enqueue_style(
		'farbest-footer',
		get_template_directory_uri() . '/css/footer.css',
		array( 'farbest-tokens' ),
		'1.0.0'
	);

	wp_enqueue_script(
		'farbest-header',
		get_template_directory_uri() . '/js/header.js',
		array(),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'farbest_block_theme_styles' );

/**
 * Render the plugin's ingredient template as post content on the block theme.
 *
 * The block template (single-fpc_ingredient.html) uses wp:post-content to
 * render the main area. This filter replaces that empty content with the
 * plugin's full PHP template output, keeping header/footer in the block theme.
 */
function farbest_render_ingredient_content( $content ) {
	if ( ! is_singular( 'fpc_ingredient' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$template = WP_PLUGIN_DIR . '/farbest-product-catalog/templates/single-ingredient.php';

	if ( ! file_exists( $template ) ) {
		return $content;
	}

	ob_start();
	// Signal the template it is embedded — plugin template checks this to skip
	// its own get_header() / get_footer() calls when running inside the block theme.
	$GLOBALS['farbest_embedded_template'] = true;
	include $template;
	unset( $GLOBALS['farbest_embedded_template'] );
	return ob_get_clean();
}
add_filter( 'the_content', 'farbest_render_ingredient_content' );
