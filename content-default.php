<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Core
 * @since Core 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		core_post_thumbnail();
	?>

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'core' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="kp-pagination-cont"><div class="kp-pagination">',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'core' ) . ' </span>%',
			) );
		
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

</article>