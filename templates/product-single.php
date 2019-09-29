<?php

get_header();
?>

<div class="kp-cont">
	<div class="row">

		<?php if ( '2' == get_theme_mod( 'product_sidebar', '1' ) ){ ?>

			<div id="sidebar" class="sidebar sidebar-left col-xs-4 col-md-3">

				<?php get_sidebar(); ?>

			</div>

		<?php } ?>

		<div id="content" class="product-content <?php if ( '1' == get_theme_mod( 'product_sidebar', '1' ) ){ echo 'blog-content-left col-xs-8 col-md-12'; } else if ( '3' == get_theme_mod( 'product_sidebar', '1' ) ){ echo 'product-content-middle col-xs-12 col-md-12'; }else if ( '2' == get_theme_mod( 'product_sidebar', '1' ) ){ echo 'blog-content-right col-xs-8 col-md-12'; } ?>">
			<main id="main" class="site-main" role="main">

				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
			
					/*
					* Include the post format-specific template for the content. If you want to
					* use this in a child theme, then include a file called called content-___.php
					* (where ___ is the post format) and that will be used instead.
					*/
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<header class="entry-header">
							<?php
								if ( is_single() ) :
									the_title( '<h1 class="entry-title">', '</h1>' );
								else :
									the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
								endif;
							?>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php
								/* translators: %s: Name of current post */
								the_content( sprintf(
									__( 'Continue reading %s', 'core' ),
									the_title( '<span class="screen-reader-text">', '</span>', false )
								) );

							?>
						</div><!-- .entry-content -->

					</article><!-- #post-## -->
					

					<?php
					// // If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				// End the loop.
				endwhile;
				?>

			</main>
		</div>

		<?php if ( '1' == get_theme_mod( 'product_sidebar', '1' ) ){ ?>

			<div id="sidebar" class="sidebar sidebar-right col-xs-4 col-md-3">

				<?php get_sidebar(); ?>

			</div>

		<?php } ?>

	</div>
</div>
<?php get_footer(); ?>