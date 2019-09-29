<?php

if ( ! function_exists( 'core_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Core 1.0
 */
function core_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/core
	 * If you're building a theme based on core, use a find and replace
	 * to change 'core' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'core' );

	add_theme_support(
		'gutenberg',
		array( 'wide-images' => true )
	);

	add_theme_support( 'align-wide' );
	add_theme_support( 'align-full' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Main Menu',      'core' ),
		'primary_mobile' => esc_html__( 'Main Menu - Mobile', 'core' ),
		'footer' => __( 'Footer Menu',      'core' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	// Allow custom mime types
	//add_filter( 'upload_mimes', 'core_mime_types' );

	// plugin check requirements
	if ( ! isset( $content_width ) ) $content_width = 900;
	add_theme_support( 'automatic-feed-links' );

	// Define standard image size, to be used with various blocks
	add_image_size("kp_banner", 1200);
	add_image_size("kp_l", 600);
	add_image_size("kp_m", 300);
	add_image_size("kp_s", 150);

	// Adds support for editor color palette. TODO optimize performance
	if(class_exists("Kenzap_Design_System")){
		
		$palette = array();
		$colors = Kenzap_Design_System::core_colors();
		$colors_arr = explode("|",get_theme_mod( 'kp_palette', 'cyan|grey|indigo' ));
		$i = 0;foreach($colors[$colors_arr[0]] as $color){ $i++;$temp = array('name'  => __( ucfirst($color)." ".$i, 'core' ),'slug'  => $color."-".$i,'color'	=> $color); array_push($palette,$temp); }
		$i = 0;foreach($colors[$colors_arr[1]] as $color){ $i++;$temp = array('name'  => __( ucfirst($color)." ".$i, 'core' ),'slug'  => $color."-".$i,'color'	=> $color); array_push($palette,$temp); }
		$i = 0;foreach($colors[$colors_arr[2]] as $color){ $i++;$temp = array('name'  => __( ucfirst($color)." ".$i, 'core' ),'slug'  => $color."-".$i,'color'	=> $color); array_push($palette,$temp); }
		add_theme_support( 'editor-color-palette', $palette);
	}
}
endif; // core_setup
add_action( 'after_setup_theme', 'core_setup' );

// Define standard image size, to be used with various blocks
function core_custom_image_size($sizes){
    $custom_sizes = array(
    'kp_banner' => '1200px',
    'kp_l' => '600px',
    'kp_m' => '300px',
    'kp_s' => '150px'
    );
    return array_merge( $sizes, $custom_sizes );
}
add_filter('image_size_names_choose', 'core_custom_image_size');

/**
 * JPEG image compression
 *
 * @since Core 1.0
 * 
 */
add_filter('jpeg_quality', function($arg){return get_theme_mod( 'jpeg_quality', '85' );});

/**
 * Register pagination
 *
 * @since Core 1.0
 * 
 */

function core_pagination( $type = 1 ){ ?>

	<div class="kp-pagination-cont">
		<div class="kp-pagination">

			<?php 
			$translated = esc_html__( 'Page', 'core' );
			$pagination = paginate_links( array(
				'type' => 'array',
				'prev_next'  => TRUE,
				'prev_text'     => '<i class="fa fa-angle-left"></i>',
				'next_text'     => '<i class="fa fa-angle-right"></i>',
			) );

			if( is_array( $pagination ) ) {
				$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
				foreach ( $pagination as $page ) {
					echo "$page";
				}
			}  ?>

		</div>
	</div>

<?php }

/**
 * Enqueue scripts and styles.
 *
 * @since Core 1.0
 */
function core_scripts() {

	$theme = wp_get_theme('core');
  	$version = $theme['Version'];
	$style = get_theme_mod( 'style_body', '2' );

	//wp_enqueue_style( 'font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array() );
	wp_enqueue_style( 'core', get_template_directory_uri() .'/css/core-style-'.$style.'.css', array(), $version, 'all' );

	// woocommerce
	if ( class_exists( 'WooCommerce' ) ){
		wp_enqueue_style( 'core-woocommerce', get_template_directory_uri() .'/css/woocommerce.css', array(), $version, 'all' );
	}

	// Load fonts
	wp_enqueue_style( 'core-fonts', core_load_fonts(), array(), null );

	// Load our main stylesheet.
	wp_enqueue_style( 'core-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	require get_template_directory() . '/inc/custom-css.php';
}
add_action( 'wp_enqueue_scripts', 'core_scripts', 100 );

//TODO add customizer setting
function wp_dequeue_gutenberg_styles() {
	wp_dequeue_style( 'wp-editor-font' ); // Wordpress core
	wp_dequeue_style( 'wp-block-library' ); // Wordpress core
    wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
}
//add_action( 'wp_print_styles', 'wp_dequeue_gutenberg_styles', 100 );

function core_admin_scripts() {

	$theme = wp_get_theme('core');
  	$version = $theme['Version'];
	$style = get_theme_mod( 'style_body', '2' );

	// Load fonts
	wp_enqueue_style( 'core-fonts', core_load_fonts(), array(), null );

	wp_enqueue_style( 'core-style-admin', get_template_directory_uri() .'/css/core-style-'.$style.'-admin.css', array(), $version, 'all' );

	require get_template_directory() . '/inc/custom-css.php';
}
add_action( 'admin_enqueue_scripts', 'core_admin_scripts' );


/**
 * Clear cache after customizer settings change
 *
 * @since Core 1.0
 *
 * @see wp_add_inline_style()
 */
function customize_save_after(){

	delete_transient('core_buffer');
}
add_action( 'customize_save_after', 'customize_save_after', 1 );

/**
 * Add custom font support
 *
 * @since Core 1.0
 *
 * @see wp_add_inline_style()
 */
function core_load_fonts(){

	$fonts_url = '';
	$font_families = array();
	
	$font1 = get_theme_mod( 'font1', '' );
	$font2 = get_theme_mod( 'font2', '' );
	$font3 = get_theme_mod( 'font3', '' );
	$kp_font = get_theme_mod( 'kp_font', '' );
	$gfa = core_google_fonts();

	// new font system in use
	if($kp_font!='' && $kp_font!='- Custom Fonts'){

		$kp_font_arr = explode("&", $kp_font);

		//print_r($kp_font_arr);

		$font1N = trim($kp_font_arr[0]);
		$font2N = trim($kp_font_arr[1]);
		$font3N = trim($kp_font_arr[1]);

	// old font system in use
	}else{

		$font1N = $font1!=''?$gfa[$font1]:"";
		$font2N = $font2!=''?$gfa[$font2]:"";
		$font3N = $font3!=''?$gfa[$font3]:"";
	}

	if ( '' !== $font1N ){ $font_families[] = $font1N.':100,200,300,400,500,600,700,800'; }
	if ( '' !== $font2N ){ $font_families[] = $font2N.':100,200,300,400,500,600,700,800'; }
	if ( '' !== $font3N ){ $font_families[] = $font3N.':100,200,300,400,500,600,700,800'; }

	//TODO work on subsets
	if(sizeof($font_families)>0){
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
}

/**
 * Display descriptions in main navigation.
 *
 * @since Core 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function core_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'core_nav_description', 10, 4 );

/**
 * Cache customizer settings. Used during wordpress migration
 *
 * @since Core 1.0
 *
 */
function core_cache_customizer( $wp_customize ) {

	set_theme_mod('coramizer', '');

	$theme		= get_stylesheet();
	$template	= get_template();
	$charset	= get_option( 'blog_charset' );
	$mods		= get_theme_mods();
	$data		= array(
		'template'  => $template,
		'mods'	  => $mods ? $mods : array(),
		'options'	  => array()
	);

	$core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);

	// Get options from the Customizer API.
	$settings = $wp_customize->settings();

	foreach ( $settings as $key => $setting ) {

		if ( 'option' == $setting->type ) {

			// Don't save widget data.
			if ( 'widget_' === substr( strtolower( $key ), 0, 7 ) ) {
				continue;
			}

			// Don't save sidebar data.
			if ( 'sidebars_' === substr( strtolower( $key ), 0, 9 ) ) {
				continue;
			}

			// Don't ssave core options.
			if ( in_array( $key, $core_options ) ) {
				continue;
			}

			$data['options'][ $key ] = $setting->value();
		}
	}

	foreach ( $option_keys as $option_key ) {
		$data['options'][ $option_key ] = get_option( $option_key );
	}

	if( function_exists( 'wp_get_custom_css_post' ) ) {
		$data['wp_css'] = wp_get_custom_css();
	}

    set_theme_mod('coramizer', serialize( $data ));
}
add_action('customize_save', 'core_cache_customizer', 100);

/**
 * Load admin dependencies.
 *
 * @since Core 1.0
 *
 */
if ( is_admin() ) {

	//load dependencies
	require_once __DIR__ . '/inc/class-tgm-plugin-activation.php';
	require_once __DIR__ . '/inc/class-plugins.php';
	require_once __DIR__ . '/inc/kenzap-import.php';
	require_once __DIR__ . '/inc/kenzap-design.php';
}

/**
 * Custom template tags for this theme.
 *
 * @since Core 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Core 1.0
 */
require get_template_directory() . '/inc/customizer-colors.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 *
 * @since Core 1.0
 */
require get_template_directory() . '/inc/woocommerce.php';
