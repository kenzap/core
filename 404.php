<?php get_header(); 

$post   = get_post( get_theme_mod( 'template-404', '' ) );
if($post) echo apply_filters( 'the_content', $post->post_content );

get_footer();
