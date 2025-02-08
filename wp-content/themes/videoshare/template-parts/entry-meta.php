<div class="entry-meta">

	<?php 
		if ( function_exists( 'pvc_get_post_views' ) ) :
		$post_id = (int) ( empty( $post_id ) ? get_the_ID() : $post_id );
		$views = pvc_get_post_views( $post_id );
	?>
		<span class="entry-views">
			<i class="far fa-eye"></i> <?php echo number_format($views); ?>
		</span>
	<?php
		endif;
	?>	

	<span class='entry-comment'><i class="far fa-comment-dots"></i> <?php comments_popup_link( __('0','videoshare'), __('1 Comment','videoshare'), __('% Comments','videoshare'), 'comments-link', __('Comments off','videoshare')); ?></span>

	<span class="sep">|</span>

	<?php if (is_single()) { ?>
		<span class="entry-category"><?php videoshare_first_category(); ?></span>
		<span class="entry-author"><?php esc_html_e('By', 'videoshare'); ?> <?php esc_url( the_author_posts_link() ); ?></span> 		
		<span class="sep set-date">&middot;</span>
	<?php } ?>

	<?php if ( (!is_category()) && (!is_single()) ) { ?>
		<span class="entry-category"><?php videoshare_first_category(); ?></span>
	<?php } ?>

	<span class="entry-date"><?php echo get_the_date(); ?></span>
					
</div><!-- .entry-meta -->