<?php 

function core_import_files() {
    return array(
        array(
            'import_file_name'           => 'Demo1',
            'import_file_url'            => 'http://xxxapiaaa.kenzap.com/demo.xml',
            'import_customizer_file_url' => 'http://xxxapiaaa.kenzap.com/demo.dat',
            'import_notice'              => __( 'If you experience server error 500 during import process please read the following <a target="_blank" href="https://github.com/proteusthemes/one-click-demo-import/blob/master/docs/import-problems.md#user-content-server-error-500" >article</a>. You may also install this theme on <a target="blank" href="xxxcloudpath" >Kenzap cloud</a> for free or request paid installation/assistance with your hosting environment. Please note that import process usually takes 2-5 minutes. Manual import file is available here: http://xxxapiaaa.kenzap.com/demo.xml', 'core' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'core_import_files' );

function core_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $main_menu_mobile = get_term_by( 'name', 'Main Menu - Mobile', 'nav_menu' );
    $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

    if(!$main_menu_mobile) $main_menu_mobile = $main_menu;
    if(!$footer_menu) $footer_menu = $main_menu;
    
    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'primary_mobile' => $main_menu_mobile->term_id,
            'footer' => $footer_menu->term_id,
        )
    );
 
    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( '- Home' );
    $blog_page_id  = get_page_by_title( '- Blog' );
    $header_id  = get_page_by_title( '- Header' );
    $footer_id  = get_page_by_title( '- Footer' );
    $not_found_id  = get_page_by_title( '- Not Found' );

    update_option( 'show_on_front', 'page' );
    if($front_page_id) update_option( 'page_on_front', $front_page_id->ID );
    if($blog_page_id) update_option( 'page_for_posts', $blog_page_id->ID );
    if($header_id) set_theme_mod( 'template-header', $header_id->ID );
    if($footer_id) set_theme_mod( 'template-footer', $footer_id->ID );
    if($not_found_id) set_theme_mod( 'template-404', $not_found_id->ID );

    // clear customizer cache
    delete_transient('core_buffer');

    // make sure links open beautifully
    core_reset_permalinks();
}
add_action( 'pt-ocdi/after_import', 'core_after_import_setup' );

function core_reset_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}
?>