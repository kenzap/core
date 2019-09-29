<?php
/**
 * The template used for displaying page content
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
		<?php the_content(); ?>
		<?php wp_link_pages( array(
				'before'      => '<div class="kp-pagination-cont"><div class="kp-pagination">',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'core' ) . ' </span>%',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
