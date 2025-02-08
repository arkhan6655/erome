<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package videoshare
 */	
?>

<article id="post-<?php the_ID(); ?>" <?php if( (videoshare_has_embed_code() || videoshare_has_embed()) ) { post_class('has-embed'); } else { post_class(); }; ?>>

	<header class="entry-header">

		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
	 	?>

		<?php get_template_part( 'template-parts/entry', 'meta' ); ?>

		<div class="entry-tags">

			<?php if (has_tag()) { ?><span class="tag-links"><?php the_tags(' ', ' '); ?></span><?php } ?>

		</div><!-- .entry-tags -->		

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'videoshare' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'videoshare' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
			
</article><!-- #post-## -->
