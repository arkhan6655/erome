<?php
/**
 * Block Patterns
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {

	register_block_pattern_category(
		'blackvideo',
		array( 'label' => esc_html__( 'blackvideo', 'blackvideo' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {

	// Large Text.
	register_block_pattern(
		'blackvideo/large-text',
		array(
			'title'         => esc_html__( 'Large text', 'blackvideo' ),
			'categories'    => array( 'blackvideo' ),
			'viewportWidth' => 1440,
			'content'       => '<!-- wp:heading {"align":"none","fontSize":"gigantic","style":{"typography":{"lineHeight":"1.1"}}} --><h2 class="has-gigantic-font-size" style="line-height:1.1">' . esc_html__( 'A new blog theme for WordPress', 'blackvideo' ) . '</h2><!-- /wp:heading -->',
		)
	);
}