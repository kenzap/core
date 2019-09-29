<?php

if ( 'post' === get_post_type() ) {
	get_template_part( 'templates/blog-single' );
} else if ( 'product' === get_post_type() ) {
	get_template_part( 'templates/product-single' );
} else if ( 'story' === get_post_type() ) {

} else if ( is_single() ) {
	
} 



