<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package videoshare
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<link rel="icon" href="http://localhost/erome/wp-content/uploads/2025/02/Erome-HD.png" type="image/png">

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="HandheldFriendly" content="true">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	//wp_body_open hook from WordPress 5.2
	if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
	} else { 
	    do_action( 'wp_body_open' ); 
	}
?>

<?php 
	if ( has_nav_menu( 'top' ) ) {
		echo '<div class="top-menu container clear">';
			wp_nav_menu( array( 'theme_location' => 'top', 'menu_id' => 'top-menu', 'menu_class' => 'sf-menu' ) );
		echo '</div>';
	}
?>

<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( 'Skip to content', 'videoshare' ); ?></a>

	<header id="masthead" class="site-header clear">

		<?php
			the_custom_header_markup();
		?>
		
		<div class="site-start clear">

			<div class="container">

			<div class="site-branding">

				<?php if ( has_custom_logo() ) { ?>
				
				<div id="logo">
					<?php the_custom_logo(); ?>
				</div><!-- #logo -->

				<?php } else { ?>

				<div class="site-title">
					<h3><a href="<?php echo esc_url( home_url('/index11') ); ?>"><?php bloginfo('name'); ?></a></h3>
				</div><!-- .site-title -->
				
				<div class="site-description">
					<?php  echo esc_html( get_bloginfo( 'description' ) ); ?>
				</div><!-- .site-description -->				

				<?php } ?>

			</div><!-- .site-branding -->

			<nav id="primary-nav" class="primary-navigation">

				<?php 
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'sf-menu', 'link_before' => '<span class="menu-text">','link_after'=>'</span>' ) );
					} else {
				?>

					<ul id="primary-menu" class="sf-menu">
						<li><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e('Home', 'videoshare'); ?></a></li>
					</ul><!-- .sf-menu -->

				<?php } ?>

			</nav><!-- #primary-nav -->		

			<div class="header-toggles">
				<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
					<span class="toggle-inner">
						<span class="toggle-icon">
							<?php videoshare_the_theme_svg( 'ellipsis' ); ?>
						</span>
						<span class="toggle-text"><?php esc_html_e( 'Menu', 'videoshare' ); ?></span>
					</span>
				</button><!-- .nav-toggle -->
			</div><!-- .header-toggles -->	

			<div class="header-search">
				<form id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" name="s" class="search-input" placeholder="<?php esc_attr_e('Search', 'videoshare'); ?>" autocomplete="off">
					<button type="submit" class="search-submit"><span class="genericon genericon-search"></span></button>		
				</form>
			</div><!-- .header-search -->

			</div><!-- .container -->

		</div><!-- .site-start -->			

	</header><!-- #masthead -->

	<div class="menu-modal cover-modal header-footer-group" data-modal-target-string=".menu-modal">

		<div class="menu-modal-inner modal-inner">

			<div class="menu-wrapper section-inner">

				<div class="menu-top">

					<button class="toggle close-nav-toggle fill-children-current-color" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".menu-modal">
						<span class="toggle-text"><?php esc_html_e( 'Close Menu', 'videoshare' ); ?></span>
						<?php videoshare_the_theme_svg( 'cross' ); ?>
					</button><!-- .nav-toggle -->

					<?php

					$mobile_menu_location = '';

					// If the mobile menu location is not set, use the secondary location as fallbacks, in that order.
					if ( has_nav_menu( 'mobile' ) ) {
						$mobile_menu_location = 'mobile';
					} elseif ( has_nav_menu( 'primary' ) ) {
						$mobile_menu_location = 'primary';
					}

					?>

					<nav class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'videoshare' ); ?>" role="navigation">

						<ul class="modal-menu reset-list-style">

						<?php
						if ( $mobile_menu_location ) {

							wp_nav_menu(
								array(
									'container'      => '',
									'items_wrap'     => '%3$s',
									'show_toggles'   => true,
									'theme_location' => $mobile_menu_location,
								)
							);

						} else {

							wp_list_pages(
								array(
									'match_menu_classes' => true,
									'show_toggles'       => true,
									'title_li'           => false,
									'walker'             => new VideoShare_Walker_Page(),
								)
							);

						}
						?>

						</ul>

					</nav>

				</div><!-- .menu-top -->

			</div><!-- .menu-wrapper -->

		</div><!-- .menu-modal-inner -->

	</div><!-- .menu-modal -->		

	<?php 
		if ( is_home() ) {
			get_template_part('template-parts/content','featured');
		} elseif ( is_category() ) {
			get_template_part('template-parts/content-category','featured');
		}
	?>

	<div id="content" class="site-content <?php if ( is_active_sidebar( 'home' ) ) { echo 'has-home-widget'; } ?> container">
		<div class="clear">
