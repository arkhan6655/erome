<?php		
	if (!get_query_var('paged')) {	
?>

<?php	

	$category = get_the_category();

	if(!empty($category)) {
	    $cat_id = $category[0]->term_id;
	}

	$args = array( 
	    'posts_per_page' => 3,
		'ignore_sticky_posts' => 1,
		'post__not_in' => get_option( 'sticky_posts' ),	
		'cat' => $cat_id,
		'meta_query' => array(
	        array(
	        	'key' => 'videoshare-featured',
	            'value' => 'yes'
	        )
	    )
	);  

	$featured_posts = new WP_Query($args);
	if ( $featured_posts->have_posts() ) {	
?>

	<div id="featured-content">

		<ul class="owl-carousel owl-theme">

		<?php
			// The Loop
			while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
		?>	

		<li class="featured-slide hentry" style="background-image: url(<?php echo esc_url( $featured_img_url ); ?>);">
				
			<div class="gradient">
			</div>
			<div class="container">
				<div class="section-wrap">
					<div class="entry-header clear">
						<div class="entry-category">
							<?php videoshare_first_category(); ?>
						</div>			
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry-meta">

							<?php 
								if ( function_exists( 'pvc_get_post_views' ) ) :
								$views = pvc_get_post_views( get_the_ID() );
							?>
								<span class="entry-views">
									<?php echo videoshare_custom_number_format($views) . ' ' . esc_html('views', 'videoshare'); ?>
								</span>

								<span class="sep">&middot;</span>		

							<?php
								endif;
							?>	
										
							<span class="entry-date"><?php echo esc_html( human_time_diff(get_the_time('U'), current_time('timestamp')) ) . ' '.  esc_html( 'ago', 'videoshare' ); ?></span>
						</div><!-- .entry-meta -->
						<div class="more-button">
							<a href="<?php the_permalink(); ?>"><i class="genericon genericon-play"></i><?php esc_html_e('Watch now', 'videoshare'); ?></a>
						</div>						
					</div><!-- .entry-header -->
				</div>
			</div>
		</li><!-- .featured-slide .hentry -->

		<?php
			endwhile;
		?>

		</ul><!-- .owl-carousel -->

	</div><!-- #featured-content -->

<?php
	}
	wp_reset_postdata();			
?>

<?php } // End if not paged ?>	