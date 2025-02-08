<?php
/**
 * VideoShare Theme Customizer.
 *
 * @package videoshare
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function videoshare_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'videoshare_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function videoshare_customize_preview_js() {
	wp_enqueue_script( 'videoshare_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'videoshare_customize_preview_js' );

function videoshare_reset_mytheme_options() { 
    remove_theme_mods();
}
add_action( 'after_switch_theme', 'videoshare_reset_mytheme_options' );