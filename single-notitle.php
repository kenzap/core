<?php

get_header(); ?>

	<main id="core" class="kp-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			* Include the post format-specific template for the content. If you want to
			* use this in a child theme, then include a file called called content-___.php
			* (where ___ is the post format) and that will be used instead.
			*/
			get_template_part( 'content', 'default' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>
	</main>
	
<?php get_footer(); ?>
