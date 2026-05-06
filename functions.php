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
		'farbest-open-sans',
		'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'farbest-tokens',
		get_template_directory_uri() . '/css/tokens.css',
		array(),
		'1.0.0'
	);

	wp_enqueue_style(
		'farbest-global',
		get_template_directory_uri() . '/css/global.css',
		array( 'farbest-tokens' ),
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

	if ( is_singular( 'fpc_ingredient' ) ) {
		wp_enqueue_style(
			'farbest-ingredient-single',
			get_template_directory_uri() . '/css/ingredient-single.css',
			array( 'farbest-tokens' ),
			'1.0.0'
		);
	}

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
