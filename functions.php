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
