<?php
/**
 * Block Styles
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 */
	function blackvideo_register_block_styles() {
		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'blackvideo-border',
				'label' => esc_html__( 'Borders', 'blackvideo' ),
			)
		);
	}
	add_action( 'init', 'blackvideo_register_block_styles' );
}
