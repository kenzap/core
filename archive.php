<?php get_header(); ?>

<section id="primary" class="archive-area blog-content">
	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="entry-header hentry">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			get_template_part( 'content-excerpt', get_post_format() );

		// End the loop.
		endwhile;

		// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'core' ),
			'next_text'          => __( 'Next page', 'core' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'core' ) . ' </span>',
		) );

	// If no content, include the "No posts found" template.
	else :
		get_template_part( 'content', 'none' );

	endif;
	?>

	</main><!-- .site-main -->
</section><!-- .content-area -->
<?php get_footer(); ?>