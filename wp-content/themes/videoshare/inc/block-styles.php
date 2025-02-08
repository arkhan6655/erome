<?php
/**
 * Block Styles
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 */
	function videoshare_register_block_styles() {
		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'videoshare-border',
				'label' => esc_html__( 'Borders', 'videoshare' ),
			)
		);
	}
	add_action( 'init', 'videoshare_register_block_styles' );
}
