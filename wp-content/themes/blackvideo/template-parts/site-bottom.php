<div id="site-bottom" class="clear">

	<?php 
		if ( has_nav_menu( 'footer' ) ) {
			wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'menu_class' => 'footer-nav' ) );
		}
	?>	

	<div class="site-info">

		<?php
			$blackvideo_theme = wp_get_theme();
		?>

		&copy;<?php echo esc_html( date("o") ); ?> <?php echo esc_html( get_bloginfo('name') ); ?> <a target="_blank" href="<?php echo esc_url( $blackvideo_theme->get( 'AuthorURI' ) ); ?>/themes/"> <?php esc_html_e('WordPress Theme', 'blackvideo'); ?></a> <?php esc_html_e('by', 'blackvideo'); ?> <a target="_blank" href="<?php echo esc_url( $blackvideo_theme->get( 'AuthorURI' ) ); ?>"><?php esc_html_e('WPEnjoy', 'blackvideo'); ?></a>

	</div><!-- .site-info -->

</div><!-- #site-bottom -->		