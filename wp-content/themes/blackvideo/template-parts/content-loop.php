<div id="post-<?php the_ID(); ?>" <?php post_class( 'ht_grid_1_4 box-effect' ); ?>>	

	<?php if ( has_post_thumbnail() ) { ?>
		<a class="thumbnail-link" href="<?php the_permalink(); ?>">
			<div class="thumbnail-wrap">
				<?php 
					the_post_thumbnail('blackvideo_post_thumb'); 
				?>
			</div><!-- .thumbnail-wrap -->
			<?php if( (blackvideo_has_embed_code() || blackvideo_has_embed()) ) { ?>
				<div class="icon-play"><i class="genericon genericon-play"></i></div>
			<?php } ?>
		</a>
	<?php } ?>	

	<div class="entry-header">

		<?php if (!is_category()) : ?>
			<div class="entry-category"><?php blackvideo_first_category(); ?></div>
		<?php endif; ?>

		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<div class="entry-meta">
			<span class="entry-date"><?php echo esc_html( human_time_diff(get_the_time('U'), current_time('timestamp')) ) . ' '.  esc_html( 'ago', 'blackvideo' ); ?></span>
		</div><!-- .entry-meta -->		
									
	</div><!-- .entry-header -->

</div><!-- #post-<?php the_ID(); ?> -->