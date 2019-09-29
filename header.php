<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php //if(class_exists("Kenzap_Plugin")) Kenzap_Plugin::free_demo(); ?>
	
	<div class="kp-cont">

		<?php // load header if its not disabled
		$kp_classes  = get_post_meta( get_the_ID(), 'kp_classes', true );
		$th = get_theme_mod( 'template-header', '' );
		if(!preg_match("/noheader/i", $kp_classes) && $th) {

			$post = get_post( $th );
			if($post) echo apply_filters( 'the_content', $post->post_content );
		}
